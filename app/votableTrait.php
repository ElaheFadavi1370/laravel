<?php
namespace App;

trait votableTrait{

    public function votes(){
        return $this->morphedByMany('App\User', 'votables');     // ,'user_id ','question_id');
    }
    public function upVotes(){
        return $this->votes()->wherePivot('vote', 1);
    }
    public function downVotes(){
        return $this->votes()->wherePivot('vote', -1);
    }
}










