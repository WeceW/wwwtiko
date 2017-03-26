<template>
    <div class="col-md-4">
        <form v-on:submit.prevent="addComment" @keydown="errors = []">
            <div :class="className">
                <label class="control-label" for="body"></label>
                <input class="form-control" type="text" name="body" id="body" v-model="body">
            </div>
            <div class="alert alert-danger" v-if="errors.length">
                <ul>
                    <li v-for="error in errors">{{error}}</li>
                </ul>
            </div>
            <button type="submit" class="btn btn-default btn-sm" :disabled="errors.length > 0">Lisää kommentti</button>
        </form>
    </div>
</template>
<script>
    export default {
        props: ['tasklistid'],
        data() {
            return {
                body: '',
                errors: []
            }
        },
        methods: {
            addComment() {
                axios.post('/tasklists/' + this.tasklistid + '/comments', {body : this.body})
                .then(response => {
                    bus.$emit('comment-created', this.body, response.data.id);
                    bus.$emit('notify', response.data.message, 'alert-success');
                    this.body = '';
                })
                .catch(error => {
                    this.errors = error.response.data.body;
                });
            }
        },
        computed: {
            className() {
                if(this.errors.length > 0) {
                    return 'form-group has-error';
                }
                return 'form-group';
            }
        }
    }
</script>