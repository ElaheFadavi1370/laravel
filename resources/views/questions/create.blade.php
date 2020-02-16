@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Ask Question</h2>
                        </div>
                        <div class="pagination justify-content-end">
                            <a href="{{route('questions.index')}}" class="btn btn-success">back to all questions</a>

                    </div>
                </div>
                    <div class="card-body">
                        {!! Form::open(['method'=>'POST', 'action'=>'QuestionsController@store']) !!}

                        <div class="form-group">
                            {!! Form::label('title', 'Question Title:') !!}
                            {!! Form::text('title', null , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('body', 'Explain your question:') !!}
                            {!! Form::textarea('body', null , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Ask this question', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                        <div class="">
                        @include('includes.errors')

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
