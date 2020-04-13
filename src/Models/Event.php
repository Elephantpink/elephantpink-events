<?php

namespace EPink\Events\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $table = 'events';

    protected $fillable = [
        'name',
        'location',
        'description',
        'date'
    ];
}
