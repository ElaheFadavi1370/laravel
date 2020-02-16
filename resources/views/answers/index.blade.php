<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$question->answers_count}} {{str_plural('answer', $question->answers_count )}}</h2>
                </div>
                <hr>
                @include('layouts._messages')
                @foreach( $question->answers as $answer)
                    <div class="media">
                        <div class="d-fex flex-column vote-controls">
                            <a title="This answer is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-2x"></i>
                            </a>
                            <span class="votes-count">1230</span>
                            <a title="This answer is not useful" class="vote-down">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </a>
                            @if (Auth::user()->can('accept', $answer))
                            <a title="mark this answer as best answer"
                               class="{{$answer->status}} mt-2" onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();"
                            >
                                <i class="fas fa-check fa-2x"></i>
                            </a>
                            <form id="accept-answer-{{ $answer->id }}" action="{{ route('answers.accept', $answer->id) }}" method="post" style="display:none;">
                                @csrf
                            </form>
                              @endif
                        </div>
                        <div class="media-body">
                            {!!  $answer->body_html !!}
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @if (Auth::user()->can('updated-question', $answer))
                                            <a href="{{route('questions.answers.edit',[$question->id, $answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endif

                                        @if (Auth::user()->can('deleted-question', $answer))
                                          <form class="form-delete" method="post" action="{{route('questions.answers.destroy' , [$question->id, $answer->id])}}">
                                              @method('DELETE')
                                              @csrf
                                              <button type="submit" class=" btn btn-sm btn-outline-danger">Delete</button>
                                          </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="float-right">
                                        <span class="text-muted">Answered {{$answer->created_at->diffForHumans()}}</span>
                                        <div class="media mt-2">
                                            <a href="{{$answer->user->url}}" class="pr-2">
                                                <img src="{{$answer->user->avatar}}">
                                            </a>
                                            <div class="media-body mt-1">
                                                <a href="{{$answer->user->url}}">{{$answer->user->name}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
