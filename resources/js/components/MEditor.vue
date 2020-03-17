<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" v-bind:href="tabId('write' ,'#')">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" v-bind:href="tabId('preview', '#')">Preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="tab-pane active" v-bind:id="tabId('write')">
                <slot></slot>
            </div>
            <div class="tab pane" v-html="preview" v-bind:id="tabId('preview')"></div>
         </div>
    </div>
</template>

<script>
   import MarkDownIt from 'markdown-it';
   import autosize from 'autosize';
   import prism from 'markdown-it-prism';
   // import 'prismjs/themes/prism.css';

   const md= new MarkDownIt();
   md.use(prism);

    export default {
    props:['body', 'name'],
       computed:{
        preview(){
            return md.render(this.body);
        }
       },
        methods: {
          tabId(tabName, hash = ''){
              return `${hash}${tabName}${this.name}`;
             }
        },
        mounted() {
            autosize(this.$el.querySelector('textarea')); // autosize(document.querySelector('textarea'));
        },
        updated() {
            autosize(this.$el.querySelector('textarea')); // autosize(document.querySelector('textarea'));
        }
    }

</script>
