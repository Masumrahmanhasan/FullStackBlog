<template>
  <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags   <span class="float-right"><Button @click="addModal=true"><Icon type="md-add" /> Add Tags</Button>
</span></p>
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th width="8%">ID</th>
								<th width="40%">Tag Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, index) in tags" :key="index" v-if="tags.length">
								<td>#{{ index+1 }}</td>
								<td class="_table_name">{{ tag.tagName }}</td>
								<td>{{ tag.created_at }}</td>
								<td>

									<Button type="info" size="small" @click="editTag(tag)">Edit</Button>
									<Button type="error" size="small" @click="showdeleteModal(tag)">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- tags adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add tag"
                    :mask-closable="false"
                    :closable="false"
                   >
                   <Input v-model="data.tagName" placeholder="Enter tag name..."/>
                    <div slot="footer">
                        <Button type="default" @click="closeModal">Close</Button>
                        <Button v-show="!editmode" type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Add tag'}}</Button>
                        <Button v-show="editmode" type="primary" @click="updateTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Update tag'}}</Button>
                    </div>
                </Modal>

                <!-- tag delete confirmation model -->
                <Modal v-model="deleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete this Tag ?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" @click="deleteTag">Delete</Button>
                    </div>
                </Modal>
			</div>
		</div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            tags: [],
            data: {
                tagName: ''
            },
            addModal: false,
            isAdding: false,
            isDeleting: false,
            editmode: false,
            deleteModal: false,
            deleteItem: {},
        }
    },
    methods: {
        async addTag(){
            this.$Loading.start();
            this.isAdding = true
            const res = await this.callApi('post', 'api/add-tag', this.data)
            if(res.status ===201){
                this.$Loading.finish();
                this.isAdding = false
                this.$emit('afterCreate')
                this.success('Tag name has been added successfully')
                this.closeModal();
            } else {
                this.$Loading.error();
                this.isAdding = false
                this.error(res.data.errors.tagName[0])
            }
        },
        async editTag(tag){
            this.editmode = true
            this.data = {
                id:tag.id,
                tagName:tag.tagName
                }
            this.addModal = true
           
        },
        async updateTag(){
            this.$Loading.start();
            const res = await this.callApi('put', 'api/update-tag/'+this.data.id, this.data)
            if(res.status ===200){
                this.$Loading.finish();
                this.$emit('afterUpdate')
                this.success('Tag name has been updated successfully')
                this.closeModal()
            } else {
                this.swr()
            }
        },
        showdeleteModal(tag){
            this.deleteModal = true
            this.deleteItem = tag
        },
        async deleteTag(){
            this.$Loading.start();
            let item = this.deleteItem
            this.isDeleting = true
            const res = await this.callApi('delete', 'api/delete-tag/'+item.id)
            if(res.status === 200){
                this.$Loading.finish();
                this.deleteItem = {}
                this.$emit('afterDelete');
                this.isDeleting = false
                this.deleteModal = false
                this.success('Tag name has been deleted successfully')
            } else {
                this.swr()
            }
        },
        async closeModal(){
            this.addModal = false
            this.editmode = false
            this.data.tagName = ''
        },
        async fetchTags(){
            const res = await this.callApi('get', 'api/get-tag-list')
            if(res.status ===200){
                this.tags = res.data
            } else {
                this.swr()
            }
        }
    },
    async created(){
        this.fetchTags()
        this.$on('afterCreate', () => {
            this.fetchTags()
        })
        this.$on('afterUpdate', () => {
            this.fetchTags();
        })
        this.$on('afterDelete', () => {
            this.fetchTags();
        })
    },


}
</script>

<style>

</style>
