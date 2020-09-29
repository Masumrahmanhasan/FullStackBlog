<template>
  <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">ROle Management   <span class="float-right"><Button @click="addModal=true"><Icon type="md-add" /> Add Roles</Button>
</span></p>
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th width="8%">ID</th>
								<th width="40%">Role Type</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role, index) in roles" :key="index" v-if="roles.length">
								<td>#{{ index+1 }}</td>
								<td class="_table_name">{{ role.name }}</td>
								<td>{{ role.created_at }}</td>
								<td>

									<Button type="info" size="small" @click="editRole(role)">Edit</Button>
									<Button type="error" size="small" @click="showdeleteModal(role)">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- tags adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add Role"
                    :mask-closable="false"
                    :closable="false"
                   >
                   <Input v-model="data.name" placeholder="Enter Role name..."/>
                    <div slot="footer">
                        <Button type="default" @click="closeModal">Close</Button>
                        <Button v-show="!editmode" type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Add Role'}}</Button>
                        <Button v-show="editmode" type="primary" @click="updateRole" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Update Role'}}</Button>
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
                        <Button type="error" size="large" long :loading="isDeleting" @click="deleteRole">Delete</Button>
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
            roles: [],
            data: {
                name: ''
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
        async addRole(){
            this.$Loading.start();
            this.isAdding = true
            const res = await this.callApi('post', 'api/create_role', this.data)
            if(res.status ===201){
                this.$Loading.finish();
                this.isAdding = false
                this.$emit('afterCreate')
                this.success('Role name has been added successfully')
                this.closeModal();
            } else {
                this.$Loading.error();
                this.isAdding = false
                this.error(res.data.errors.name[0])
            }
        },
        async editRole(role){
            this.editmode = true
            // this.data = {
            //     id:tag.id,
            //     tagName:tag.tagName
            //     }
            this.addModal = true
           
        },
        async updateRole(){
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
        showdeleteModal(role){
            this.deleteModal = true
            this.deleteItem = role
        },
        async deleteRole(){
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
        async fetchRoles(){
            const res = await this.callApi('get', 'api/get_roles')
            if(res.status ===200){
                console.log(res)
                this.roles = res.data
            } else {
                this.swr()
            }
        }
    },
    async created(){
        this.fetchRoles()
        this.$on('afterCreate', () => {
            this.fetchRoles()
        })
        this.$on('afterUpdate', () => {
            this.fetchRoles();
        })
        this.$on('afterDelete', () => {
            this.fetchRoles();
        })
    },


}
</script>

<style>

</style>
