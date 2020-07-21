import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  	deleteModalObj:{
  		showDeleteModal: false,
  		url:'',
  		isDeleted : false,
  	}
  },

  getters:{
  	getDeleteModal(state){
  		return state.deleteModalObj
  	}
  },

  mutations:{
  	setDeletModalObj(state, data){
  		 state.deleteModalObj = data
  	},
  	setDeleteModal(state, data){
  		state.deleteModalObj.showDeleteModal = false
  		state.deleteModalObj.isDeleted = data
  	}
  },

  actions: {

  },

})