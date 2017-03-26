<template>
    <div class="col-md-6">
        <comment-entry
                :comment="comment"
                :candelete="candelete"
                v-for="comment in comments"
                @commentdeleted="deleteComment(comment)">
        </comment-entry>
        <div v-if="loading == true">Ladataan kommentteja...</div>
        <div v-if="comments.lenght == 0 && loading == false">Ei vielä yhtään kommenttia...</div>
    </div>
</template>

<script>
    import CommentEntry from './CommentEntry.vue'
    export default {
        props: {
            tasklistid: {
                type: String,
                required: true,
            },
            candelete: {
                type: String,
                required: true,
            }
        },
        data() {
            return {
                comments: [],
                loading: true
            }
        },
        components: {
            CommentEntry,
        },
        created() {
            bus.$on('comment-created', (body, id) => {
                this.comments.push({
                    body: body,
                    created_at: 'Just now',
                    id: id
                });
            });
            axios.get('/comments/' + this.tasklistid)
            .then(response => {
                this.loading = false;
                this.comments = response.data;
            })
            .catch(error => console.log(error));
        },
        methods: {
            deleteComment(comment) {
                axios.delete('/comments/' + comment.id)
                .then(response => {
                    this.removeComment(comment);
                    bus.$emit('notify', response.data, 'alert-success');
                })
                .catch(error => {
                    bus.$emit('notify', error.response.data, 'alert-danger');
                });
            },
            removeComment(comment) {
                let index = this.comments.indexOf(comment);
                this.comments.splice(index, 1);
            }
        }
    }
</script>