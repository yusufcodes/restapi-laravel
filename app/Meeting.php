<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    // Fields that can be passed into a Meeting constructor upon creation
    protected $fillable = ['time', 'title', 'description'];

    // Meetings that belong to a user
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
