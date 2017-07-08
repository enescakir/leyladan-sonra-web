<?php

namespace App;

class EmailSample extends BaseModel
{
  // Properties
  protected $table    = 'email_samples';
  protected $fillable = ['name', 'category', 'text'];
}
