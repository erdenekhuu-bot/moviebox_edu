<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use AchyutN\LaravelHLS\Traits\ConvertsToHls;

class Movie extends Model
{
    use ConvertsToHls;

    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $rules = [
        'name' => 'required'
    ];
    protected $fillable = [
        'name'
    ];

}
