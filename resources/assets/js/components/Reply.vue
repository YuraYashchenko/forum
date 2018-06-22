<script>
    import Favourite from './Favourite.vue';

    export default {
        props: ['attributes'],

        components: { Favourite },

        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                }).then(() => {
                    this.editing = false;

                    flash('Updated!');
                })
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id)
                    .then((data) => {
                        $(this.$el).fadeOut(300, () => flash('Deleted!'));
                    });
            }
        }
    }
</script>