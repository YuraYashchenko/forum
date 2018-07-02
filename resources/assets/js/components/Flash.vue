<template>
    <div class="alert alert-message" :class="'alert-' + level" v-show="this.show" role="alert" v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],

       data () {
           return {
               body: '',
               show: false,
               level: ''
           };
       },

        created() {
          if (this.message) {
              this.flash(this.message);
          }

          window.events.$on('flash', message => this.flash(message));
        },

        methods: {
            hide() {
                setTimeout(() => this.show = false, 3000);
            },

            flash(payload) {
                this.body = payload.message;
                this.show = true;
                this.level = payload.level;

                this.hide();
            }
        }
    }
</script>

<style>
    .alert-message {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
