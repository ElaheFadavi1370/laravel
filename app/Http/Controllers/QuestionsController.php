<?php

namespace App\Http\Controllers;
use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        \DB::enableQueryLog();
        $questions= Question::latest()->paginate(5);
       return view('questions.index' , compact('questions'));
//        dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question= new Question;
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
//        $input= $request->all();
//        $request->user()->questions()-create($input);
//        return redirect('/questions');
      $request->user()->questions()->create($request->only('title', 'body'));
      return redirect()->route('questions.index')->with('success' , "Your question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view ('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question= Question::findOrFail($id);
        if(\Gate::allows('updated-question', $question)){
            return view("questions.edit", compact('question'));
        }
       abort(403 , "Access denied");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        if (\Gate::allows('updated-question', $question)) {
            $question->update($request->only('title', 'body'));
            return redirect()->route('questions.index')->with('success', "Your question has been updated");
        }
        abort(403 , "Access denied");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if (\Gate::allows('deleted-question', $question)) {
            $question->delete();
            return redirect()->route('questions.index')->with('success', "Your question has been Deleted");
        }
        abort(403, "Access denied");
    }
}
