<template>
    <div class="media post">
<!--        @include('shared._vote', [ 'model'=>$answer ])-->
        <vote v-bind:class="answer" name="answer"></vote>
        <div class="media-body">
            <form v-show="authorize('modify', answer) && editing"> //editing == true
                <div class="form-group" v-on:submit.prevent="update">
                    <m-editor v-bind:body="body" v-bind:name="uniqueName">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                    </m-editor>
                </div>
                <button class="btn btn-primary" v-bind:disabled="isInvalid">Update</button>
                <button class="btn btn-secondary" v-on:click="cancel" type="button">Cancel</button>
            </form>
            <div v-show="!editing"> //v-if="editing ==false"
                <div v-bind:id="uniqueName" v-html="bodyHtml" ref="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
<!--                            @if (Auth::user()->can('updated-question', $answer))-->
                            <a v-if="authorize('modify', answer)" v-on:click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
<!--                            @endif-->
<!--                            @if (Auth::user()->can('deleted-question', $answer))-->
                            <button v-if="authorize('modify' , answer)" v-on:click="destroy" class=" btn btn-sm btn-outline-danger">Delete</button>
<!--                            @endif-->
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
<!--                        @include('shared._author', [-->
<!--                        'model'=>$answer,-->
<!--                        'label'=>'answered'-->
<!--                        ])-->
                        <user-info v-bind:model="answer" label="Answered"></user-info>
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

    export default {
        components: { MEditor, UserInfo, Vote },
        props: ['answer'],
        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditingCache: null
            }
        },
        methods: {
            edit: function () {
                this.beforeEditingCache = this.body;
                this.editing = true;
            },
            cancel: function () {
                this.body = this.beforeEditingCache;
                this.editing = false;
            },
            update: function () {
                axios.patch(this.endpoint, {
                    body: this.body
                })
                    .then(res => {
                        this.editing = false;
                        this.bodyHtml = res.data.body_html;
                       this.$toast.success(res.data.message , "success", {timeout: 3000});
                    })
                    .catch(err => {
                        this.$toast.error(err.response.data.message , "error", {timeout: 3000});
                        // alert(err.response.data.message);
                        // console.log("something went wrong")
                    });
            },
            destroy: function () {
                if(confirm('are you sure?')){
                    axios.delete(this.endpoint)
                    .then(res => {
                        this.$emit('deleted')
                        // $(this.$el).fadeOut(500 , ()=> {
                        //     this.$toast.success(res.data.message , "success", {timeout: 3000});
                        // })
                    });

                }
            }
        },
        computed: {
            isInvalid: function () {
                return this.body.length < 10;
            },
           endpoint: function () {
              return `questions/${this.questionId}/answers/${this.id} `;
           },
            uniqueName: function () {
                return `answer-${this.id}`; //answer-3
            }
        }
    }
</script>

