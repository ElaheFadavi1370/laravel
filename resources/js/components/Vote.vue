<template>
    <div class="d-fex flex-column vote-controls">
        <a v-on:click="voteUp" v-bind:title="title('up')"
           class="vote-up" v-bind:class="classes">
            <i class="fas fa-caret-up fa-2x"></i>
        </a>
        <span class="votes-count">{{count}}</span>
        <a v-on:click="voteDown" v-bind:title="title('down')"
           class="vote-down" v-bind:class="classes">
            <i class="fas fa-caret-down fa-2x"></i>
        </a>
        <favorite v-if="name === 'question'" :question="model"></favorite>
        <accept  v-else :answer="model"></accept>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import Accept from './Accept.vue';

    export default {
    props:['name', 'model'],

        computed:{
        classes: function () {
            return this.signedIn ? '' : 'off';
        },
          endpoint()  {
            return `/${this.name}s/${this.id}/vote `
          }

       },
       components:{
        Favorite,
        Accept
       },

        data(){
        return{
          count:this.model.votes_count || 0,
          id: this.model.id
        }
},
        methods:{
        title: function (votetype) {
            let titles= {
                up: `This ${name} is useful`,
                down: `This ${name} is not useful`
            };
            return titles[votetype];
        },
          voteUp: function () {
             this._vote(1);
          }  ,
            voteDown: function () {
             this._vote(-1);
            },
            _vote:function(vote) {
            if (!this.signedIn) {
                this.$toast.warning('please log in to vote', "Warning", {
                    timeout: 3000 ,
                    position: 'bottomLeft'
                });
                return;
            }
             axios.post(this.endpoint, {vote})
                .then(res=>{
                    this.$toast.success(res.data.message, "success", {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    this.count= res.data.votesCount;
                })
            }
         }
    }
</script>


