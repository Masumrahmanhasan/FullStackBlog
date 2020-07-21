<template>
	<div>

		<Modal
				:value="getDeleteModal.showDeleteModal"
				width="360">
		    <p slot="header" style="color:#f60;text-align:center">
		        <Icon type="ios-information-circle"></Icon>
		        <span>Delete confirmation</span>
		    </p>

		    <div style="text-align:center">
		        <p>Are You sure You want to delete this?</p>
		    </div>

		    <div slot="footer">
		        <Button type="error" size="large" long :loading="isDeleting" @click="deleteTag">Delete</Button>
		    </div>
		</Modal>

	</div>
</template>
<script>
	import {mapGetters} from 'vuex'
	export default {
		data(){
			return {
				isDeleting: false,
			}
		},
		methods: {
			async deleteTag(){
	            this.$Loading.start();
	            this.isDeleting = true
	            const res = await this.callApi('delete', this.getDeleteModal.url)
	            if(res.status === 200){
	                this.$Loading.finish();
	                this.success('Delete Successfull')
	                this.$store.commit('setDeleteModal', true)

	            } else {
	                this.swr()
	            }
	        }
		},

		computed: {
			...mapGetters(['getDeleteModal'])
		}
	}
</script>