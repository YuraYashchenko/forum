<template>
    <button :class="classes" @click="toggle">Subscribe</button>
</template>

<script>
    export default {
        props: ['active'],

        data() {
            return {
                isSubscribed: this.active
            }
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.isSubscribed ? 'btn-primary' : 'btn-default'
                ]
            }
        },

        methods: {
            toggle() {
                axios[this.isSubscribed ? 'delete' : 'post'](`${location.pathname}/subscriptions`);

                this.isSubscribed = ! this.isSubscribed;
            }
        }
    }
</script>