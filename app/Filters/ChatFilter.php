<?php

namespace App\Filters;

use EnesCakir\Helper\Base\Filter;

class ChatFilter extends Filter
{
    protected $filters = ['faculty_id', 'volunteer_id', 'child_id', 'via', 'status', 'search'];
}