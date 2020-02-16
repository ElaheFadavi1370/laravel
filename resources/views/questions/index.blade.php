@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h2>All Questions</h2>
                  </div>
                    <div class="pagination justify-content-end">
                        <a href="{{route('questions.create')}}" class="btn btn-success">Ask Question</a>
                    </div>
                </div>
            </div>
                <div class="card-body">
                   @include('layouts._messages')
                   @foreach($questions as $question)
                     <div class="media">
                       <div class="d-flex flex-column counters">
                         <div class="vote">
                             <strong>{{$question->votes}}</strong>{{str_plural('vote', $question->votes )}}
                         </div>
                         <div class="status {{$question->status}}">
                             <strong>{{$question->answers_count}}</strong>{{str_plural('answer', $question->answers_count )}}
                         </div>
                         <div class="views">
                           <strong>{{$question->views}}</strong> {{str_plural('view', $question->views )}}
                         </div>
                       </div>
                      <div class="media-body">
                          <div class="d-flex align-items-center">
                              <h3 class="mt-0"><a href="{{$question->url}}">{{$question->title}}</a></h3>
                              <div class="ml-auto">
                                     @if (Auth::user()->can('updated-question', $question))
                                        <a href="{{route('questions.edit', $question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                                     @endif

                                      @if (Auth::user()->can('deleted-question', $question))
                                          {!! Form::model($question, ['method'=>'DELETE', 'action'=>['QuestionsController@destroy', $question->id]]) !!}
                                          <div class="form-group">
                                          {!! Form::submit('Delete', ['class'=>'btn btn-sm btn-outline-danger']) !!}
                                          </div>
                                          {!! Form::close() !!}
                                     @endif
                              </div>
                          </div>
                          <p class="lead">
                              Asked by
                            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                              <small class="text-muted">{{$question->created_at->diffForHumans()}}</small>
                          </p>
                          {{str_limit($question->body , 5)}}
                      </div>
                     </div>
                       <hr>
                  @endforeach
                       <div class="pagination justify-content-center">
                       <div class="pagination pagination-sm">
                       {{$questions->links()}}
                    </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@stop
