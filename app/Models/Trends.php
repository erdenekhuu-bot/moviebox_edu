<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trends extends Model
{
    protected $table = 'trends';
    protected $guarded = [];
    protected $casts = [];

    protected $hidden = [];
    protected $appends = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
