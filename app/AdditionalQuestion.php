<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalQuestion extends Model
{
    protected $guarded = [];
    protected $table = 'job_listing_additional_questions';

    public function answers()
    {
        return $this->hasMany('App\AdditionalQuestionAnswer');
    }
}
