<?php

namespace App\Filters;

use App\Models\News;

class NewFilter extends Filter
{
    protected $filters = ['channel_id', 'search', 'download'];

    protected function download()
    {
        $mapper = function ($item) {
            return [
                'id'         => $item->id,
                'title'      => $item->title,
                'desc'       => $item->desc,
                'channel'    => $item->channel->name,
                'link'       => $item->link,
                'created_at' => $item->created_at,
            ];
        };
        News::download($this->builder, $mapper);
    }
}
