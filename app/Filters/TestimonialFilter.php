<?php

namespace App\Filters;

use App\Models\Testimonial;
use EnesCakir\Helper\Base\Filter;

class TestimonialFilter extends Filter
{
    protected $filters = ['priority', 'via', 'search', 'download'];

    protected function download()
    {
        Testimonial::download($this->builder);
    }
}
