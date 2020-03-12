<template>
    <a title="Click to mark as favorite question (Click again to undo)"
       v-bind:class="classes" v-on:click.prevent="toggle">
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{count}}</span>
    </a>
</template>
<script>
    export default {
        props: ['question'],
        data() {
            return {
                isFavorited: this.question.is_favorited,
                count: this.question.favorites_count,
                signedIn: true,
                id: this.question.id
            }
        },
        computed:{
            classes(){
                return [
                'favorite', 'mt-2',
                    !this.signedIn ? 'off' : (this. isFavorited ? 'favorited' : '')
            ];

            },
            endpoint(){
                return `/questions/${this.id}/favorites`;
            }
        },
        methods: {
            toggle: function () {
                if(!this.signedIn){
                    this.$toast.warning('please login to favorite the question', "warning",{
                        timeout:3000 ,
                        position: 'bottomLeft'
                    });
                    return;
                }
                this.isFavorited ? this.destroy() : this.create();
            },
            destroy:function () {
                axios.delete(this.endpoint)
                .then(res=> {
                    this.count--;
                    this.isFavorited= false;
                });
            },
            create:function () {
                axios.post(this.endpoint)
                .then(res=>{
                    this.count++;
                    this.isFavorited = true;
                });
            }
        }
    }

</script>
