<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;

class News extends Model
{
    use BaseActions;
    protected $table = 'news';
    protected $fillable = ['title', 'desc', 'link', 'channel_id'];

    // Relations
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('title', 'like', '%' . $search . '%')
                    ->orWhere('desc', 'like', '%' . $search . '%');
        });
    }

    // Global Methods

    public static function download($news)
    {
        $news = $news->get();
        Excel::create('LS_Haberler_' . date('d_m_Y'), function ($excel) use ($news) {
            $newsData = $news->map(function ($item, $key) {
                return [
                    'id'         => $item->id,
                    'title'      => $item->title,
                    'desc'       => $item->desc,
                    'channel'    => $item->channel->name,
                    'link'       => $item->link,
                    'created_at' => $item->created_at,
                ];
            });
            $excel->sheet('Haberler', function ($sheet) use ($newsData) {
                $sheet->fromArray($newsData, null, 'A1', true);
            });
        })->download('xlsx');
    }
}
