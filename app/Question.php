<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use votableTrait;
    protected $fillable = [
        'title',
        'body',
    ];
    protected $appends=[
        'created_date', 'is_favorited', 'favorites_count','body_html'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);

    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);

    }
    public function getCreatedDateAttribute(){
        return $this->created_at;
         }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {

        return \Parsedown::instance()->text($this->body);

    }

    public function answers_count()
    {
        return $this->hasMany('App\Answer');

    }

    public function answers()
    {
        return $this->hasMany('App\Answer')->orderBy('votes_count', 'DESC');
    }
    public function acceptBestAnswer(Answer $answer)

    {

        $this->best_answer_id = $answer->id;

        $this->save();

    }
    public function favorites(){
        return $this->belongsToMany('App\User', 'favorites')->withTimestamps();     // ,'user_id ','question_id');
    }
    public function isFavorited(){
        return $this->favorites()->where('user_id' , auth()->id()) ->count() > 0;
    }
    public function getIsFavoritedAttribute(){
       return $this->isFavorited();
    }
    public function getFavoritesCountAttribute(){
        return $this->favorites()->count();
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





    public function getVotesCountAttribute(){
        return $this->votes()->count();
    }
}
