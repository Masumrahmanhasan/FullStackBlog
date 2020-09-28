<template>
  <div>
       <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin Users   <span class="float-right"><Button @click="addModal=true"><Icon type="md-add" /> Add Admin</Button>
</span></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                                <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                                <!-- TABLE TITLE -->


                                <!-- ITEMS -->
                            <tr v-for="(user, index) in users" :key="index" v-if="users.length">
                                <td>#{{ index+1 }}</td>
                                <td>{{ user.fullName }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.userType }}</td>
                                <td>{{ user.created_at }}</td>
                                <td>

                                    <Button type="info" size="small" @click="editUsers(user)">Edit</Button>
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
                    title="Add Admin"
                    :mask-closable="false"
                    :closable="false"
                   >
                   <Input type="text" v-model="data.fullName" placeholder="Enter Full name..."/>
                        <div class="space"></div>
                   <Input type="email" v-model="data.email" placeholder="Enter email..."/>
                        <div class="space"></div>
                   <Input type="password" v-model="data.password" placeholder="Enter password..."/>

                        <div class="space"></div>

                    <Select v-model="data.userType" placeholder="Select admin type">
                        <Option value="Admin">Admin</Option>
                        <Option value="Editor">Editor</Option>
                    </Select>
                    <div slot="footer">
                        <Button type="default" @click="closeModal">Close</Button>
                        <Button v-show="!editmode" type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Add Admin'}}</Button>
                        <Button v-show="editmode" type="primary" @click="updateAdmin" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...': 'Update Admin'}}</Button>
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
            users: [],
            data: {
                fullName:'',
                email:'',
                password:'',
                userType:'Admin',
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
        async addAdmin(){
            this.$Loading.start();
            this.isAdding = true
            const res = await this.callApi('post', 'api/create_user', this.data)
            if(res.status ===201){
                this.$Loading.finish();
                this.isAdding = false
                this.$emit('afterCreate')
                this.success('User Created successfully')
                this.closeModal();
            } else {
                this.$Loading.error();
                for(let i in res.data.errors){
                    this.error(res.data.errors[i][0])
                }
                this.isAdding = false
            }
        },
        async editUsers(user){
            this.editmode = true
            this.data = {
                    id:user.id,
                    fullName:user.fullName,
                    email:user.email,
                    userType:user.userType,
                }
            this.addModal = true
           
        },
        async updateAdmin(){
            this.$Loading.start();
            const res = await this.callApi('post', 'api/update-user', this.data)
            if(res.status ===200){
                this.$Loading.finish();
                this.$emit('afterUpdate')
                this.success('User updated successfully')
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
            this.data.fullName = ''
            this.data.email = ''
            this.data.password = ''
            this.data.userType = 'Admin'

        },
        async fetchUsers(){
            const res = await this.callApi('get', 'api/get_users')
            if(res.status ===200){
                this.users = res.data
            } else {
                this.swr()
            }
        }
    },
    async created(){
        this.fetchUsers()
        this.$on('afterCreate', () => {
            this.fetchUsers()
        })
        this.$on('afterUpdate', () => {
            this.fetchUsers();
        })
        this.$on('afterDelete', () => {
            this.fetchUsers();
        })
    },


}
</script>

<style>

</style>
