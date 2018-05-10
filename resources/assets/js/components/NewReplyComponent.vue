<template>
	<div>
		<div v-if="signedIn">
            <div class="form-group">
                <textarea name="body" rows="5" class="form-control" placeholder="Got something to say?" v-model="body" required></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success" @click="addReply">Reply</button>
            </div>
        </div>
    	<div v-else>
    		<p>Please <a href="/login">sign in</a> to participate in this discussion.</p>
    	</div>

    </div>
</template>
<script>
	export default {
		data() {
			return {
				body : '',
			}
		},
		computed : {
			signedIn() {
				return window.App.signedIn;
			}
		},
		methods : {
			addReply() {
				axios.post(location.pathname + '/replies', {body : this.body})
					.then( ({data}) => {
						this.body = '';
						flash('Your reply has been posted');
						this.$emit('created', data);
					});
			}
		}
	}
</script>