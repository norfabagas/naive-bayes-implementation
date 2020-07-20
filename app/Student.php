<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'study_program',
        'year_class',
        'born_data',
        'religion',
        'gender',
        'address',
        'parent_data',
        'purpose',
        'dump'
    ];

    /**
     * return has one App\Score
     */
    public function score()
    {
        return $this->hasOne('App\Score');
    }

    /**
     * return bornData from json datatype
     */
    public function bornData()
    {
        return json_decode($this->born_data);
    }

    /**
     * return parentData from json datatype
     */
    public function parentData()
    {
        return json_decode($this->parent_data);
    }

    /**
     * return dump (raw data) from json datatype
     */
    public function dump()
    {
        return json_decode($this->dump);
    }
}
