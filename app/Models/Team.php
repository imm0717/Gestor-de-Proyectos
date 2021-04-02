<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active',
        'user_id'
    ];

    public function owner(){

        return $this->belongsTo('App\Models\User');
    }

    public function members(){

        return $this->belongsToMany('App\Models\User');
    }
}
