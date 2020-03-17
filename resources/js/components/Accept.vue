<template>
    <a  v-if="canAccept" title="mark this answer as best answer"
        v-bind:class="classes" v-on:click.prevent="create">
        <i class="fas fa-check fa-2x"></i>
    </a>

    <a v-else="accepted" title="The question owner accepted this answer as best answer"
       v-bind:class="classes">
        <i class="fas fa-check fa-2x"></i>
    </a>
</template>

<script>
    import eventBus from '../event-bus';
    export default {
        props:['answer'],

        data(){
            return {
                isBest: this.answer.is_best,
                id: this.answer.id
            }
        },
        created(){
            eventBus.$on('accepted', id=>{
                this.isBest=(id===this.id);
            })
        },
        method: {
            create: function () {
                axios.post(this.endpoint)
                    .then(res=> {
                        this.$toast.success(res.data.message, "success", {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });
                        this.isBest = true;
                        eventBus.$emit('accepted', this.id);
                    })
                }
             },
        computed: {
            canAccept: function () {
                return this.authorize('accept', this.answer);
                // return true;
            },
            accepted: function () {
                return !this.canAccept && this.isBest;
            },
            classes() {
                return [
                    'mt-2',
                    this.isBest ? 'vote-accepted' : ''];
            },
            endpoint() {
                return `/answers/${this.id}/accept`;
            }

        }

    }
</script>

