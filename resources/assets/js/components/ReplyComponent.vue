<script>
	export default {
		props: ['reply'],
		data() {
			return {
				editing : false,
				body : this.reply.body
			}
		},
		methods: {
			update() {
				axios.patch('/replies/' + this.reply.id, {
					body : this.body
				});

				this.editing = false;

				flash('Updated!');
			},
			cancel() {
				this.editing = false;
				this.body = this.reply.body;
			}
		}
	}
</script>