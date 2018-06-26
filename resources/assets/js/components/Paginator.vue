<template>
    <ul class="pagination" v-show="shouldPaginate">
        <li class="page-item" v-if="previousUrl"><a class="page-link" href="#" @click.prevent="page--">Previous</a></li>
        <li class="page-item" v-if="nextUrl"><a class="page-link" href="#" @click.prevent="page++">Next</a></li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                nextUrl: false,
                previousUrl: false
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.nextUrl || !! this.previousUrl;
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.previousUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().changeUrl();
            }
        },

        methods: {
            broadcast() {
                return this.$emit('updated', this.page);
            },

            changeUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>