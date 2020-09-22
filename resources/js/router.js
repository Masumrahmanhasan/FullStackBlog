import Vue from "vue"
import VueRouter from "vue-router";

Vue.use(VueRouter)
import home from './components/pages/Home'
import tags from './components/pages/Tags'
import category from './components/pages/Category'
import adminusers from './components/pages/AdminUsers'
const routes = [
    {
        path: '/',
        component:home,
    },
    {
        path:'/tags',
        component:tags,
    },
    {
        path:'/category',
        component:category,
    },
    {
        path:'/adminusers',
        component:adminusers,
    }
]

export default new VueRouter({
    mode: 'history',
    routes

})
