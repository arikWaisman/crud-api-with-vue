<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Behavior extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'breakfast', 'daily_routine', 'feeling',
    // ];

    /**
     * Get the user who owns the behavior.
     */
    public function user() {

        return $this->belongsTo('App\User');

    }
}
