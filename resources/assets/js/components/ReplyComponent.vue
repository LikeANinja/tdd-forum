<template>
	<div>
		<div :id="'reply-' + replyId" class="card">
	        <div class="card-header">
	        	<div class="level">
	        		<div class="flex">
	    		        <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name"></a> said
	    		        <span v-text="ago"></span>
	    			</div>
	    	        <div v-if="signedIn">
	                    <favorite :reply="data"></favorite>
	    	        </div>
	    	    </div>
	        </div>
	        <div class="card-body">
	            <div v-if="editing">
	                <div class="form-group">
	                    <textarea name="" class="form-control" v-model="body"></textarea>
	                </div>
	                <button class="btn btn-sm btn-primary" @click="update">Update</button>
	                <button class="btn btn-sm btn-link" @click="cancel">Cancel</button>
	            </div>
	            <div v-else v-text="body"></div>
	        </div>

	        <div class="card-footer level" v-if="canUpdate()">
	            <button class="btn btn-default btn-sm m-r-1" @click="editing = true">Edit</button>
	            <button class="btn btn-danger btn-sm m-r-1" @click="destroy">Delete</button>
	        </div>
	    </div>
	</div>
</template>
<script>
	import Favorite from './FavoriteComponent.vue';
	import moment from 'moment';
	export default {
		props: ['data'],
		components : { Favorite },
		data() {
			return {
				editing : false,
				body : this.data.body,
				replyId : this.data.id
			}
		},
		computed : {
			signedIn() {
				return window.App.signedIn;
			},
			ago() {
				return moment(this.data.created_at).fromNow();
			}
		},
		methods: {
			update() {
				axios.patch('/replies/' + this.data.id, {
					body : this.body
				});

				this.editing = false;

				flash('Updated!');
			},
			cancel() {
				this.editing = false;
				this.body = this.data.body;
			},
			destroy() {
				axios.delete('/replies/' + this.data.id).then( () => {
					this.$emit('deleted', this.data.id)
				});
			},
			canUpdate() {
				return this.authorize(user => this.data.user_id == user.id);
				//return window.App.user && this.data.user_id == window.App.user.id;
			}
		}
	}
</script>