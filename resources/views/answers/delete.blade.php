<?php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="DELETE">
                            @csrf
                            @method('DELETE')
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-outline-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
