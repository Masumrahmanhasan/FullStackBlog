<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category <span class="float-right">
                        <Button @click="addModal=true"><Icon type="md-add" /> Add Category</Button>
                        </span>
                    </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Category Icon Image</th>
								<th>Category Name</th>
                                <th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
                            <tr v-for="(category, index) in categories" :key="index" v-if="categories.length">
                                <td>{{ index+1 }}</td>
                                <td class="table_image"><img :src="'storage/uploads/'+category.iconImage" width="40" height="50" alt=""></td>
                                <td>{{ category.categoryName }}</td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click="editCategory(category)">Edit</Button>
                                    <Button type="error" size="small" @click="showdeleteModal(category)">Delete</Button>
                                </td>
                            </tr>
						</table>
					</div>
				</div>

                <!-- Category add modal -->

                <Modal
                    v-model="addModal"
                    title="Add category"
                    :mask-closable="false"
                    :closable="false"
                   >
                    <Input v-model="data.categoryName" placeholder="Enter category name..."/>
                    <div class="space"></div>
                    <Upload type="drag"
                    action="api/upload"
                    :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    v-show="data.iconImage==''"
                    ref="uploads"
                    :show-upload-list="true"
                    >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="data.iconImage">
                        
                        <img :src="`storage/uploads/${data.iconImage}`">
                        <div class="demo-upload-list-cover">
                            <!-- <Icon type="ios-eye-outline" @click.native="handleView"></Icon> -->
                            <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                        </div>
                    
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="closeModal">Close</Button>
                        <Button v-show="!editmode" @click="addCategory" type="primary" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Add Category'}}</Button>
                        <Button v-show="editmode" @click="updateCategory" type="primary" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'updating...': 'Update Category'}}</Button>
                    </div>
                </Modal>

                <delete-modal></delete-modal>
			</div>   
        </div>
    </div>
</template>

<script>
import DeleteModal from './base/deleteModal'
export default {
    components: {
        DeleteModal
    },

    data(){
        return {
            categories: [],
            data: {
                categoryName:'',
                iconImage: ''
            },
            addModal:false,
            editmode:false,
            isAdding:false,
            token: ''
        }
    },
    methods: {
        async addCategory(){
            this.$Loading.start();
            this.isAdding = true
            const res = await this.callApi('post', 'api/add-category', this.data)
            if(res.status ===201){
                this.$Loading.finish();
                this.isAdding = false
                this.$emit('afterCreate')
                this.success('Category has been added successfully')
                this.closeModal();
            } else {
                this.$Loading.error();
                this.isAdding = false
                if (res.data.errors.categoryName) {
                    this.error(res.data.errors.categoryName[0])
                }
                if (res.data.errors.iconImage) {
                    this.error(res.data.errors.iconImage[0])
                }

            }
        },
        async fetchCategory(){
            const res = await this.callApi('get', 'api/get-categories')
            if(res.status ===200){
                this.categories = res.data
            } else {
                this.swr()
            }
        },
        async editCategory(category){
            this.editmode = true
            this.data = {
                id:category.id,
                categoryName:category.categoryName,
                iconImage: category.iconImage
            }
            this.addModal = true

        },
        async updateCategory(){
            
            this.$Loading.start();
            const res = await this.callApi('put', 'api/update-category/'+this.data.id, this.data)
            if(res.status ===200){
                this.$Loading.finish();
                this.$emit('afterUpdate')
                this.success('Category has been updated successfully')
                this.closeModal()
            } else {
                this.swr()
            }
        },

        showdeleteModal(category){

            const deleteModalObj = {
                    showDeleteModal: true,
                    url:'api/detele-category/'+category.id,
                }
            this.$store.commit('setDeletModalObj', deleteModalObj)
        },

        closeModal(){
            this.addModal = false
            this.data.categoryName = ''
            this.data.iconImage = ''
            this.editmode = false
            this.$refs.uploads.clearFiles()
        },
        handleSuccess (res, file) {
            this.data.iconImage = res
        },
        handleError (res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            });
        },
        async deleteImage(){
            let image = this.data.iconImage
            this.data.iconImage = ''
            this.$refs.uploads.clearFiles()
            const res = await this.callApi('post', 'api/delete-image', {imageName:image})
        }
    },
    async created(){
        this.token = window.Laravel.csrfToken
        this.fetchCategory();
        this.$on('afterCreate', () => {
            this.fetchCategory();
        })
        this.$on('afterUpdate', () => {
            this.fetchCategory();
        })
    }
}
</script>

<style>

</style>
