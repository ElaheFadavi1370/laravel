@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{$question->title}}</h1>
                            </div>
                            <div class="pagination justify-content-end">
                                <a href="{{route('questions.index')}}" class="btn btn-success">back to all questions</a>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-fex flex-column vote-controls">
                                <a title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-2x"></i>
                                </a>
                                <span class="votes-count">1230</span>
                                <a title="This question is not useful" class="vote-down">
                                    <i class="fas fa-caret-down fa-2x"></i>
                                </a>
                                <a title="Click to mark as favorite question (click again to undo)" class="favorite mt-2 favorited">
                                    <i class="fas fa-star fa-2x"></i>
                                   </a>
                                <span class="favorites-count">123</span>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">Answered {{$question->created_at->diffForHumans()}}</span>
                                    <div class="media mt-2">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     @include('answers.index')
     @include('answers.create')
    </div>
@stop
