<?php
/**
 * Created by PhpStorm.
 * User: EnesCakir
 * Date: 5/6/16
 * Time: 12:44 AM
 */
//
function set_active($path, $active = 'active')
{
    if (is_array($path)) {
        foreach ( $path as $p)
            if(Request::is($p))
                return $active;
        return '';
    }

    return Request::is($path) ? $active : '';
}

function session_success($text)
{
    Session::flash('success_message', $text);
}

function session_error($text)
{
    Session::flash('error_message', $text);
}

function session_info($text)
{
    Session::flash('info_message', $text);
}



function BaseActions(Illuminate\Database\Schema\Blueprint $table)
{
    $table->integer('created_by')->unsigned()->nullable();
    $table->integer('updated_by')->unsigned()->nullable();
    $table->integer('deleted_by')->unsigned()->nullable();

    $table->foreign('created_by')->references('id')->on('users');
    $table->foreign('updated_by')->references('id')->on('users');
    $table->foreign('deleted_by')->references('id')->on('users');
}

function Approval(Illuminate\Database\Schema\Blueprint $table)
{
    $table->dateTime('approved_at')->nullable();
    $table->integer('approved_by')->unsigned()->nullable();
    $table->foreign('approved_by')->references('id')->on('users');
}


function removeTurkish($string){
    $charsArray = [
        'c'    => ['ç', 'Ç'],
        'g'    => ['ğ', 'Ğ'],
        'i'    => ['I', 'İ', 'ı'],
        'o'    => ['Ö','ö'],
        's'    => ['Ş', 'ş'],
        'u'    => ['ü', 'Ü'],
    ];
    foreach ($charsArray as $key => $val) {
        $string = str_replace($val, $key, $string);
    }
    return $string;
}
