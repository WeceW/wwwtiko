<template>
    <div class="media">

        <div class="media-body">
            <h5 class="media-heading"><small>Lähetetty {{comment.created_at}}</small>
            </h5>
            <!-- @{{ @can('manage-tasks') }} -->
            <button type="button"
                    @click="deleteComment(comment)"
                    class="close">
                <span>&times;</span>
            </button>
            <!-- @{{ @endcan }} -->
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