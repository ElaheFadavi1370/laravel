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
                   @forelse($questions as $question)
                     @include('questions._excerpt')
                       @empty
                       <div class="alert alert-danger">
                           <strong>Sorry</strong> there are no questions available
                       </div>
                  @endforelse
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
