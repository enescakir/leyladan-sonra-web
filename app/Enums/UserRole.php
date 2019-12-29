<?php

namespace App\Enums;

use EnesCakir\Helper\Base\Enum;

class UserRole extends Enum
{
    const All = null;
    const Admin = 'admin';
    const FacultyManager = 'manager';
    const FacultyBoard = 'board';
    const Relation = 'relation';
    const Gift = 'gift';
    const Website = 'website';
    const Normal = 'normal';
    const Blood = 'blood';
    const Content = 'content';
    const Graduated = 'graduated';
    const Left = 'left';
}