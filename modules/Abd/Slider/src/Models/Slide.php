<?php

namespace Abd\Slider\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    const STATUS_DISABLE = "disable";
    const STATUS_ENABLE = "enable";

    static $statuses = [
      self::STATUS_DISABLE,
      self::STATUS_ENABLE
    ];
}
