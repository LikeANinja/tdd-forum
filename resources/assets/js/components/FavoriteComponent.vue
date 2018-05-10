<template>
	<button :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart-empty"></span>
        <span v-text="count"></span>
    </button>
</template>
<script>
	export default {
		props: ['reply'],
		data() {
			return {
				count : this.reply.favoritesCount,
				active : this.reply.isFavorited
			}
		},
		computed : {
			classes() {
				return ['btn', this.active ? 'btn-primary' : 'btn-default', 'btn-sm']
			},
			endPoint() {
				return '/replies/' + this.reply.id + '/favorites';
			}
		},
		methods : {
			toggle() {
				return this.active ? this.destory() : this.create();
			},
			destory() {
				axios.delete(this.endPoint).then( () => {
					this.active = false;
					this.count--;
				})
			},
			create() {
				axios.post(this.endPoint).then( () => {
					this.active = true;
					this.count++;
				})
			}
		}
	}
</script>
