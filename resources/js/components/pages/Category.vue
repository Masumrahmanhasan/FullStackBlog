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
								<th>Category Name</th>
								<th>Category Icon</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

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
                    <Input v-model="data.categoryName" placeholder="Enter category name..." style="margin-bottom:10px"/>
                    <div class="space"></div>
                    <Upload type="drag" 
                    action="api/upload"
                    :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :on-remove="handleList"
                    >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="image_thumb" v-if="data.iconImage">
                        <img :src="`/storage/uploads/${data.iconImage}`">
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="closeModal">Close</Button>
                        <Button v-show="!editmode" type="primary" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Add tag'}}</Button>
                        <Button v-show="editmode" type="primary" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Update tag'}}</Button>
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
        closeModal(){
            this.addModal = false
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
        handleList(res, file){
            this.data.iconImage = ''
            console.log(res)
        }
    },
    async created(){
         this.token = window.Laravel.csrfToken
    }
}
</script>

<style>

</style>
