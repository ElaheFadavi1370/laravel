<template>
   <div>
       <div class="row mt-4" v-cloak v-if="count > 0">
           <div class="col-md-12">
               <div class="card">
                   <div class="card-body">
                       <div class="card-title">
                           <h2>{{title}}</h2>
                       </div>
                       <hr>
                       <answer v-on:deleted="remove(index)" v-for="(answer, index) in answers" v-bind:answer="answer" v-bind:key="answer.id"></answer>
                       <div class="text-center mt-3" v-if="nextUrl">
                           <button v-on:click.prevent="fetch(nextUrl)" class="btn btn-secondary">Load more answers</button>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <new-answer v-on:created="add" v-bind:question-id="question.id"></new-answer>
   </div>
</template>

<script>
    import Answer from './Answer.vue';
    import NewAnswer from './NewAnswer.vue';
    import Prism from "markdown-it-prism";

    export default {
   // props: ['answers' , 'count'],
        props:['question'],

        data(){
            return{
             questionId: this.question.id,
             count: this.question.answers_count,
             answers: [],
             nextUrl: null
            }
        },
        create(){
          this.fetch(`/questions/${this.questionId}/answers`)
        },

        methods:{
            add: function(answer){
                this.answers.push(answer);
                this.count++;
                this.$nextTick(()=> {
                    this.highlight(`answer-${answer.id}`);
                })
            },
            highlight: function(id='') {
                let el;
                if(!id) {
                    el  = this.$refs.bodyHtml;
                } else {
                  el=document.getElementById(id) ;
                }
                if(el) Prism.highlightAllUnder(el);
            },
            remove: function(index) {
              this.answers.splice(index, 1);
             this.count--;
            },
          fetch: function (endpoint) {
           axios.get(endpoint)
              .then(({data})=>{
                this.answers.push(...data.data);
                this.nextUrl=data.next_page_url;
              })
          }
        },

        computed:{
       title: function () {
         return this.count + '' + (this.count > 1 ? 'answers' : 'answer');
       }

     },

        components: {Answer, NewAnswer}

    }
</script>

