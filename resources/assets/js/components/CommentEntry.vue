<template>
    <div class="media">

        <div class="media-body">
            <h5 class="media-heading"><small>Lähetetty {{comment.created_at}}</small>
            </h5>
            <button type="button"
                    @click="deleteComment(comment)"
                    class="close">
                <span>&times;</span>
            </button>
            {{comment.body}}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['comment', 'candelete'],
        methods: {
            deleteComment(comment) {
                this.$emit('commentdeleted', comment);
            }
        }
    }
</script>