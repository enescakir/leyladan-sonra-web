<?php

namespace App\Filters;

use App\Models\Testimonial;

class TestimonialFilter extends Filter
{
    protected $filters = ['priority', 'via', 'search', 'download'];

    protected function download()
    {
        Testimonial::download($this->builder);
    }
}
