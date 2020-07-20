<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'student_id',
        'gpa',
        'course_credit',
        'status',
        'dump'
    ];

    /**
     * belongsTo Student relationship
     */
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    /**
     * return gpa from json datatype
     */
    public function gpa()
    {
        return json_decode($this->gpa);
    }

    /**
     * return courseCredit from json datatype
     */
    public function courseCredit()
    {
        return json_decode($this->course_credit);
    }

    /**
     * return status from json datatype
     */
    public function status()
    {
        return json_decode($this->status);
    }

    /**
     * return dump (raw data) from json datatype
     */
    public function dump()
    {
        return json_decode($this->dump);
    }
}
