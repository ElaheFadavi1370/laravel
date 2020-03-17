<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form v-on:submit.prevent="create">
                        <div class="form-group">
                            <m-editor v-bind:body="body" name="new-answer">
                            <textarea v-model="body" class="form-control" required></textarea>
                            </m-editor>
                        </div>
                        <div class="form-group">
                            <div class="form-control">
                                <button class="btn btn-lg btn-outline-primary" v-bind:disabled="isInvalid">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MEditor from "./MEditor";
   export default {
       props:['questionId'],

       components:{MEditor},
        data() {
            return {
                body: ''
            }
        },
        methods:{
           create:function () {
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body
            })
               .catch(error => {
                   this.$toast.error(error.response.data.message, "Error");
               })
               .then(({data})=>{
                   this.$toast.success(data.message, "Success");
                   this.body='';
                   this.$emit('created', data.answer);
               })
           }
        },
        computed:{
           isInvalid() {
               return !this.signedIn || this.body.length < 10;
           }
        }
    }
</script>


