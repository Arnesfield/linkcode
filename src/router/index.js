import Vue from 'vue'
import Router from 'vue-router'

import Login from '@/components/Login'
import Dashboard from '@/components/Dashboard'

import NotFound from '@/components/errors/NotFound'

Vue.use(Router)

export default new Router({
  routes: [
    // auth 0
    {
      path: '/',
      name: 'Login',
      component: Login,
      meta: {
        title: 'LinkCode Login',
        auth: 0
      }
    },

    // panelists
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard,
      meta: {
        title: 'Dashboard',
        auth: 3
      }
    },

    // last resort
    {
      path: '*',
      name: 'NotFound',
      component: NotFound,
      meta: {
        title: 'Error 404',
        auth: -1
      }
    }
  ]
})
