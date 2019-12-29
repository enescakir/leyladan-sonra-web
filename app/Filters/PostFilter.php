<?php

namespace App\Filters;

use App\Models\Post;
use EnesCakir\Helper\Base\Filter;

class PostFilter extends Filter
{
    protected $filters = ['faculty_id', 'type', 'approval', 'search', 'download'];

    protected function faculty_id($faculty_id)
    {
        return $this->builder->faculty($faculty_id);
    }

    protected function approval($approval)
    {
        return $this->builder->approved($approval);
    }

    protected function download()
    {
        Post::download($this->builder);
    }
}
