<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable=[
       'user_id',
       'question_id' ,
        'body',
        'votes_count'
    ];

    public function question(){
        return $this->belongsTo('App\Question');

    }
    public function user(){
        return $this->belongsTo('App\User');

    }
    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });
        static::deleted(function ($answer) {
            $question= $answer->question;
            $question->decrement('answers_count');
            if($question->best_answer_id == $answer->id) {
              $question->best_answer->id = NULL;
              $question->save();
            }
        });
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
        public function getStatusAttribute(){
        return $this->id == $this->question->best_answer_id ? 'vote-accepted' : '';
        }

     }
