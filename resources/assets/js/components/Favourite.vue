<template>
        <button :class="classes" @click="toogle">
            <span class="glyphicon glyphicon-heart"></span>
            <span v-text="count"></span>
        </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favouritesCount,
                isFavourite: this.reply.isFavourite
            };
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.isFavourite ? 'btn-primary' : 'btn-default'
                ];
            },

            url () {
                return '/replies/' + this.reply.id + '/favourites';
            }
        },

        methods: {
            toogle() {
                this.isFavourite ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.url)
                    .then(() => {
                        this.isFavourite = true;
                        this.count++;
                    });
            },

            destroy() {
                axios.delete(this.url)
                    .then(() => {
                        this.isFavourite = false;
                        this.count--;
                    });
            }
        }
    }
</script>