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
                           @include('shared._vote',[
                               'model'=>$question
                             ])
                            <div class="media-body">
                                {!! $question->body_html !!}
                               <div class="row">
                                   <div class="col-4"></div>
                                   <div class="col-4"></div>
                                   <div class="col-4">
{{--                                       @include('shared._author', [--}}
{{--                                     'model'=> $question,--}}
{{--                                     'label'=> 'asked'--}}
{{--                                   ])--}}
                                      <user-info v-bind:model={{ $question }} label="Asked"></user-info>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     @include('answers.index',[
    'answers'=>$qustion->answers,
    'answersCount'=>$qustion->answers_count
    ])
     @include('answers.create')
    </div>
@stop
