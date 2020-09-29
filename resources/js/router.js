import Vue from "vue"
import VueRouter from "vue-router";

Vue.use(VueRouter)
import home from './components/pages/Home'
import tags from './components/pages/Tags'
import category from './components/pages/Category'
import adminusers from './components/pages/AdminUsers'
import login from './components/pages/Login'
import role from './components/pages/Role'

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
    },
    {
        path:'/role',
        component:role,
    },
    {
        path:'/login',
        component:login,
    }
]

export default new VueRouter({
    mode: 'history',
    routes

})
