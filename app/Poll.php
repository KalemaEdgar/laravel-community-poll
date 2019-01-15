<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'title'
    ];
    
    /** This provides the relationship between the Polls and Questions */
    public function questions() 
    {
        return $this->hasMany('App\Question');
    }
}
