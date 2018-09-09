<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use Excel;
use App\Models\User;

class Sms extends Model
{
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'sms';
    protected $fillable = [
        'title', 'message', 'category', 'receiver_count', 'sent_by'
    ];

    // Relations
    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('id', $search)
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%");
        });
    }

    // Accessors

    // Mutators

    // Methods
    public static function toSenderSelect($placeholder = null, $category = '')
    {
        $result = static::where('category', $category)->with('sender')->orderBy('id', 'DESC')->get()->pluck('sender.full_name', 'sender.id')->sort();
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }

    public function send($people)
    {
        $to = is_array($people) ?
            array_reduce($people, function ($reduced, $person) {
                return $reduced . '<number>' . $person . '</number>';
            }, '') :
            '<number>' . $people . '</number>';

        $username = config('services.iletimerkezi.username');
        $password = config('services.iletimerkezi.password');

        $xml = "
        <request>
            <authentication>
                <username>{$username}</username>
                <password>{$password}</password>
            </authentication>
            <order>
                <sender>{$this->attributes['title']}</sender>
                <sendDateTime>01/05/2013 18:00</sendDateTime>
                <message>
                    <text><![CDATA[{$this->attributes['message']}]]></text>
                    <receipents>{$to}</receipents>
                </message>
            </order>
        </request>
        ";

        $site_name = config('services.iletimerkezi.url') . '/send-sms';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $site_name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $result = curl_exec($ch);
        return $result;
    }

    public static function checkBalance()
    {
        $username = config('services.iletimerkezi.username');
        $password = config('services.iletimerkezi.password');

        $xml = "
        <request>
            <authentication>
                <username>{$username}</username>
                <password>{$password}</password>
            </authentication>
        </request>
        ";

        $site_name = config('services.iletimerkezi.url') . '/get-balance';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $site_name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        return (string) simplexml_load_string($result)->balance->sms;
    }
}
