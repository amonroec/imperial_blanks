<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['style', 'color_code', 'tags'];

    protected $casts = ['tags' => 'array'];
}
