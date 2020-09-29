<template>

	<div class="container">
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
        	<div class="login_header">
	        	<h1>Login Panel</h1>
        	</div>
	        	<div class="space"></div>
        	<Input type="email" v-model="data.email" placeholder="example@email.com"/>
                <div class="space"></div>
           	<Input type="password" v-model="data.password" placeholder="Password"/>
	            <div class="space"></div>
	        <div class="login_footer">
	        	<Button type="primary" @click="login" :disabled="isLogging" :isloading="isLogging">
	        		{{ isLogging ? 'Loading...' : 'Login'}}
	        	<Icon type="md-exit" /></Button>
	        </div>
        </div>
    </div>

</template>

<script>
export default {

  name: 'Login',

	data () {
	    return {
	    	data:{
	    		email:'',
	    		password:''
	    	},
	    	isLogging:false
    	}
    
  	},
	methods:{
    	async login(){
            this.isLogging = true
    		const res = await this.callApi('post', 'api/admin_login', this.data)
    		if(res.status === 200){
    			this.success(res.data.msg)
                window.location = '/';
    			
    		} else {
    			if (res.status === 401) {
    				this.info(res.data.msg)
    			} else {
                    for(let i in res.data.errors)
                    {
                        this.error(res.data.errors[i][0])
                    }
    			}
    		}
            this.isLogging = false
    	}
    }
}
</script>

<style lang="css" scoped>
	._1adminOverveiw_table_recent{
		margin: 0 auto;
		margin-top: 20%;
	}
	.login_header {
		text-align:center;
		margin-bottom: 25px;
	}
</style>