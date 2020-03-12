<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use votableTrait;
    protected $fillable = [
        'user_id',
        'body',
    ];
    protected $appends=['created_date', 'body_html','is_best'];

    public function question()
    {
        return $this->belongsTo('App\Question');

    }

    public function user()
    {
        return $this->belongsTo('App\User');

    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });
        static::deleted(function ($answer) {
            $question = $answer->question;
            $question->decrement('answers_count');
            if ($question->best_answer_id == $answer->id) {
                $question->best_answer->id = NULL;
                $question->save();
            }
        });
    }
    public function getCreatedDateAttribute(){
        return $this->created_at;
         }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);

    }

    public
    function getBodyHtmlAttribute()
    {

        return \Parsedown::instance()->text($this->body);

    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }
//    public function votes(){
//        return $this->morphedByMany('App\User', 'votables');     // ,'user_id ','question_id');
//    }
//    public function upVotes(){
//    return $this->votes()->wherePivot('vote', 1);
//    }
//    public function downVotes(){
//        return $this->votes()->wherePivot('vote', -1);
//    }
}

