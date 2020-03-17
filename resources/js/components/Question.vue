<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form class="card-body" v-show="authorize('modify' , question) && editing" v-on:submit.prevent="update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-body">
                            <div class="form-group" v-on:submit.prevent="update">
                                <m-editor v-bind:body="body" v-bind:name="uniqueName">
                                <textarea v-model="body" rows="10" class="form-control" required></textarea>
                                </m-editor>
                            </div>
                            <button class="btn btn-primary" v-bind:disabled="isInvalid">Update</button>
                            <button class="btn btn-secondary" v-on:click="cancel" type="button">Cancel</button>
                            </div>
                        </div>
                </form>
                <div class="card-body" v-show="!editing">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{title}}</h1>
                        </div>
                        <div class="pagination justify-content-end">
                            <a href="/questions" class="btn btn-success">back to all questions</a>
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        <vote v-bind:model="model" name="question"></vote>
<!--                          @include('shared._vote',[-->
<!--                           'model'=>$question-->
<!--                            ])-->
                        <div class="media-body">
                            <div v-html="bodyHtml" ref="bodyHtml"></div>
<!--                            {!! $question->body_html !!}-->
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <a v-if="authorize('modify', question)" v-on:click.prevent="edit"  class="btn btn-sm btn-outline-info">Edit</a>
                                        <button v-if="authorize('deleteQuestion' , question)" v-on:click="destroy" class=" btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
<!--                                 @include('shared._author', [-->
<!--                                  'model'=> $question,-->
<!--                                   'label'=> 'asked'-->
<!--                                     ])-->
                                    <user-info v-bind:model="question" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vote from './Vote.vue';
    import UserInfo from './UserInfo.vue';
    import MEditor from './MEditor.vue';
    import Prism from 'markdown-it-prism';

    export default {
        props: ['question'],
        components:{Vote, UserInfo, MEditor},

        data(){
          return {
              title: this.question.title,
              body: this.question.body,
              bodyHtml: this.question.body_html,
              id: this.question.id,
              editing: false,
              beforeEditingCache: null
          }
        },
        computed:{
            isInvalid: function () {
               return this.body.length < 10 || this.title.length < 10;
                },
            endpoint: function () {
                return `/questions/${this.id}`;
            },
            uniqueName: function () {
             return `question-${this.id}`;
            }
        },
        methods:{
            edit: function () {
                this.beforeEditingCache = {
                    body: this.body,
                    title: this.title};
                this.editing = true;
            },
            cancel: function () {
                this.body = this.beforeEditingCache.body;
                this.title = this.beforeEditingCache.title;
                this.editing = false;
                const el  = this.$refs.bodyHtml;
                if(el) Prism.highlightAllUnder(el);

            },
            update: function () {
                axios.put(this.endpoint, {
                    body: this.body,
                    title:this.title
                })
                    .catch(({response}) => {
                        this.$toast.error(response.data.message , "error", {timeout: 3000});
                    })
                    .then(({data}) => {
                        this.bodyHtml = data.body_html;
                        this.$toast.success(data.message , "success", {timeout: 3000});
                        this.editing = false;
                    })

            },
            destroy: function () {
                if(confirm('are you sure?')){
                    axios.delete(this.endpoint)
                        .then(({data}) => {
                            this.$toast.success(data.message, "success", {timeout: 2000});
                        });
                  setTimeout(()=>{
                      window.location.href="/questions";
                  }, 3000)
                }
            }

        }
    }
</script>
