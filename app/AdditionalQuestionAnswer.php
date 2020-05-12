<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalQuestionAnswer extends Model
{
    protected $guarded = [];
    protected $table = 'job_listing_additional_question_answers';

    public function additional_question()
    {
        return $this->hasOne('App\AdditionalQuestion');
    }
}
