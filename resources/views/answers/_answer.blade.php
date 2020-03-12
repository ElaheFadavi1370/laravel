<answer v-bind:answer={{ $answer }} inline-template>
    <div class="media post">
        @include('shared._vote', [
          'model'=>$answer
         ])
        <div class="media-body">
            <form v-if="editing"> //editing == true
                <div class="form-group" v-on:submit.prevent="update">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" v-bind:disabled="isInvalid">Update</button>
                <button class="btn btn-secondary" v-on:click="cancel" type="button">Cancel</button>
            </form>
            <div v-else> //v-if="editing ==false"
             <div v-html="bodyHtml"></div>
              <div class="row">
                  <div class="col-4">
                      <div class="ml-auto">
                          @if (Auth::user()->can('updated-question', $answer))
                              {{--                            <a href="{{route('questions.answers.edit',[$question->id, $answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>--}}
                              <a v-on:click.prevent="edit"  class="btn btn-sm btn-outline-info">Edit</a>
                          @endif

                          @if (Auth::user()->can('deleted-question', $answer))
                                  <button v-on:click="destroy" class=" btn btn-sm btn-outline-danger">Delete</button>
                          @endif
                      </div>
                  </div>
                  <div class="col-4"></div>
                  <div class="col-4">
                      {{--                   @include('shared._author', [--}}
                      {{--                    'model'=>$answer,--}}
                      {{--                    'label'=>'answered'--}}
                      {{--                     ])--}}
                      <user-info v-bind:model={{ $answer }} label="Answered"></user-info>
                  </div>
              </div>
          </div>
        </div>
    </div>
</answer>


