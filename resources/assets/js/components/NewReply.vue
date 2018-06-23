<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group mt-3">
                <textarea name="body" id="body" placeholder="Type a reply" rows="5" v-model="body" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <button class="form-control" @click="addReply">Post</button>
            </div>
        </div>


        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to leave a reply
        </p>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                body: ''
            };
        },

        computed: {
            signedIn () {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, {
                    body: this.body
                }).then(({data}) => {
                    this.body = '';
                    this.$emit('created', data);
                });
            }
        }
    }
</script>