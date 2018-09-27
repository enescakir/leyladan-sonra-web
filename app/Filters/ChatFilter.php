<?php

namespace App\Filters;


class ChatFilter extends Filter
{
    protected $filters = ['faculty_id', 'volunteer_id', 'child_id', 'via', 'status', 'search'];
}