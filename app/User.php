<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends=[
       'url' , 'avatar'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function questions()
    {

        return $this->hasMany('App\Question');
    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->id);
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');

    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Question', 'favorites')->withTimestamps();     // ,'user_id ','question_id');
    }

    public function voteQuestions()
    {
        return $this->morphedByMany('App\Question', 'votables');
}
    public function voteAnswers()
    {
        return $this->morphedByMany('App\Answer', 'votables');
    }
    public function voteQuestion(Question $question ,$vote){
        $voteQuestions= $this->voteQuestions();

        $this->_vote($voteQuestions, $question, $vote);
    }


    public function voteAnswer(Answer $answer ,$vote)
    {
        $voteAnswers = $this->voteAnswers();

        $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote ($relationship , $model, $vote){
        if($relationship->where('votable_id', $model)->exists())
        {
            $relationship->updateExistingPivot($model, ['vote'=>$vote]);
        }
        else {
            $relationship->attach($model, ['vote'=>$vote]) ;

        }
        $model->load('votes');
        $downVotes= (int) $model->upVotes()->sum('vote');
        $upVotes= (int) $model->downVotes()->sum('vote');

        $model->votes_count= $downVotes + $upVotes;
        $model->save();
    }
//    public function voteQuestion(Question $question ,$vote){
//        $voteQuestions= $this->voteQuestions();
//        if($voteQuestions->where('votable_id', $question)->exists()){
//            $voteQuestions->updateExistingPivot($question, ['vote'=>$vote]);
//        }
//        else {
//            $voteQuestions->attach($question, ['vote'=>$vote]) ;
//
//        }
//        $question->load('votes');
//        $downVotes= (int) $question->upVotes()->sum('vote');
//        $upVotes= (int) $question->downVotes()->sum('vote');
//
//        $question->votes_count= $downVotes + $upVotes;
//        $question->save();
//    }
//

//    public function voteAnswer(Answer $answer ,$vote){
//        $voteAnswers= $this->voteAnswers();
//        if($voteAnswers->where('votable_id', $answer)->exists())
//        {
//            $voteAnswers->updateExistingPivot($answer, ['vote'=>$vote]);
//        }
//        else {
//            $voteAnswers->attach($answer, ['vote'=>$vote]) ;
//
//        }
//        $answer->load('votes');
//        $downVotes= (int) $answer->upVotes()->sum('vote');
//        $upVotes= (int) $answer->downVotes()->sum('vote');
//
//        $answer->votes_count= $downVotes + $upVotes;
//        $answer->save();
//    }

}
