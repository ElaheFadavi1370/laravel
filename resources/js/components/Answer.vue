<script>
    export default {
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
                        $(this.$el).fadeOut(500 , ()=> {
                            this.$toast.success(res.data.message , "success", {timeout: 3000});
                        })
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
           }
        }
    }
</script>

