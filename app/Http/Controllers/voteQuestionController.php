<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class voteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function __invoke(Question $question)
    {
            $vote = (int) request()->vote;

         $votesCount =  auth()->user()->voteQuestion($question, $vote);

        if(request()->expectsJson()){
            return response()->json([
                'message'=> "Thanks for the feedback",
                'votesCount'=>$votesCount
            ]);
        }
            return back();
    }
}
