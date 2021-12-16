<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $fillable = [
        'dep_name', 'location', 'manager_id','parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */

    public function users()
    {
        return $this->hasMany('App\\User');
    }

    public function childs()
    {
        return $this->hasMany('App\\Departments', 'parent_id', 'dep_id');
    }
}
