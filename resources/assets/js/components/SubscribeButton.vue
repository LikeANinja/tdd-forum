<template>
	<button :class="classes" @click="subscribe">Subscribe</button>
</template>
<script>
	export default {
		props: ['active'],
		data() {
			return {

			}
		},
		computed : {
			classes () {
				return['btn', this.active ? 'btn-primary' : 'btn-default']
			}
		},
		methods : {
			subscribe() {

				axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions')
					.then( () => {
						this.active = !this.active;
					});
			}
		}
	}
</script>