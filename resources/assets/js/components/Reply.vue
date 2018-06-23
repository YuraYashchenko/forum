<template>
        <div :id="'reply-' + data.id" class="card mt-3 mb-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <p>
                            <a :href="`/profile/${data.user.name}`" v-text="data.user.name"></a>
                            said <span v-text="ago"></span>
                        </p>
                    </div>

                        <favourite :reply="data" v-if="signedIn"></favourite>

                </div>
            </div>

            <div class="card-body">
                <div v-if="editing" >
                    <div class="form-group">
                        <textarea class="form-control" rows="3" v-model="body"></textarea>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-sm btn-default ml-3" @click="update">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                    </div>
                </div>

                <div v-else v-text="body"></div>
            </div>

            <div class="card-footer">
                <div v-if="canUpdate">
                    <button class="btn btn-sm btn-default ml-3" @click="editing = true">Edit</button>
                    <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
</template>

<script>
    import Favourite from './Favourite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: { Favourite },

        data() {
            return {
                editing: false,
                body: this.data.body
            };
        },

        computed: {
            ago () {
               return moment(this.data.user.created_at).fromNow();
            },

            signedIn() {
                return window.App.signedIn;
            },

            canUpdate() {
                return this.authorize(user => this.data.user.id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).then(() => {
                    this.editing = false;

                    flash('Updated!');
                })
            },

            destroy() {
                axios.delete('/replies/' + this.data.id)
                    .then(() => {
                        this.$emit('deleted')

                        flash('You delete a reply!')
                    });
            }
        }
    }
</script>