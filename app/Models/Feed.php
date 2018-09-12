<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;

class Feed extends Model
{
    use BaseActions;
    // Properties
    protected $table    = 'feeds';
    protected $fillable = ['role', 'desc', 'type', 'link', 'faculty_id'];

    // Relations
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    // Scopes

    // Accessors
    public function getIconLabelAttribute()
    {
        $icon_code = $this->attributes['type'];
        switch ($icon_code) {
      case "1":
        $result = ["warning", "child"];
      break;
      case "2":
        $result = ["info", "male"];
      break;
      case "3":
        $result = ["success", "gift"];
      break;
      case "4":
        $result = ["danger", "trash"];
      break;
      default:
        $result = ["", ""];
      break;
    }
        return '<div class="label label-sm label-' . $result[0] . '"> <i class="fa fa-' . $result[1] . '"></i></div>';
    }
}
