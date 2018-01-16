<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

use Excel;

class Channel extends Model
{
    use Base;
    // Properties
    protected $table    = 'channels';
    protected $fillable = ['name', 'logo', 'category'];

    // Relations
    public function news()
    {
        return $this->hasMany(News::class);
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('category', 'like', '%' . $search . '%');
    }

    // Global Methods
    public static function download($channels)
    {
        $channels = $channels->get(['id', 'name', 'category', 'logo', 'created_at']);
        Excel::create('LS_HaberKanallari_' . date("d_m_Y"), function ($excel) use ($channels) {
            $channels = $channels->each(function ($item, $key) {
                $item->logo = asset(upload_path("channel", $item->logo));
            });
            $excel->sheet('Kanallar', function ($sheet) use ($channels) {
                $sheet->fromArray($channels, null, 'A1', true);
            });
        })->download('xlsx');
    }

    public static function toSelect($empty = false)
    {
        $res = Channel::orderBy('name')->pluck('name', 'id');
        return $empty ? collect(['' => ''])->merge($res) : $res;
    }
}
