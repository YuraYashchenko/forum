<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @updated="fetch"></paginator>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import collection from '../mixins/collection';
    import NewReply from './NewReply.vue';

    export default {
        components: { Reply, NewReply },

        mixins: [collection],

        data () {
            return {
                dataSet: false
            };
        },

        created() {
            this.fetch()
        },

        computed: {
            endpoint() {
                return window.location.pathname + '/replies';
            }
        },

        methods: {
            fetch (page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            refresh({ data }) {
                this.dataSet = data;
                this.items = data.data
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${window.location.pathname}/replies?page=${page}`;
            }
        }
    }
</script>