<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Sms extends Model
{
    use Base;
    // Properties
    protected $table    = 'sms';
    protected $fillable = ['title', 'message', 'category', 'receiver_count', 'sent_by'];

    // Methods
    public function send($people)
    {
        $to = is_array($people) ?
    array_reduce($people, function ($reduced, $person) {
        return $reduced . "<number>" . $person . "</number>";
    }, "")
    : "<number>" . $people . "</number>";

        $username = env('ILETI_USERNAME');
        $password = env('ILETI_PASSWORD');

        $xml = "<request>
    <authentication>
    <username>" . $username . "</username>
    <password>" . $password . "</password>
    </authentication>
    <order>
    <sender>" . $this->attributes['title'] . "</sender>
    <sendDateTime>01/05/2013 18:00</sendDateTime>
    <message>
    <text><![CDATA[" . $this->attributes['message'] . "]]></text>
    <receipents>
    " . $to . "
    </receipents>
    </message>
    </order>
    </request>";

        $site_name = env('ILETI_URL') . "/send-sms";

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
        $username = env('ILETI_USERNAME');
        $password = env('ILETI_PASSWORD');

        $xml = "<request>
    <authentication>
    <username>" . $username . "</username>
    <password>" . $password . "</password>
    </authentication>
    </request>";

        $site_name = env('ILETI_URL') . "/get-balance";

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
