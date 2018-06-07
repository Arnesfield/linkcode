import Vue from 'vue'
import Router from 'vue-router'

import HomePage from '@/components/HomePage'
import Login from '@/components/Login'

Vue.use(Router)

export default new Router({
  routes: [
    // auth 0
    {
      path: '/',
      name: 'HomePage',
      component: HomePage,
      meta: {
        title: 'Home',
        auth: 0
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: {
        title: 'Login',
        auth: 0
      }
    }
  ]
})
