import Vue from 'vue'
import Router from 'vue-router'

import Login from '@/components/Login'

import Dashboard from '@/components/Dashboard'
import Vote from '@/components/Vote'
import Votes from '@/components/Votes'

import ManageUsers from '@/components/manage/ManageUsers'
import ManageProjects from '@/components/manage/ManageProjects'
import ManageCategories from '@/components/manage/ManageCategories'

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

    // admin
    {
      path: '/manage/users',
      name: 'ManageUsers',
      component: ManageUsers,
      meta: {
        icon: 'account_circle',
        title: 'Manage Users',
        auth: 1
      }
    },
    {
      path: '/manage/projects',
      name: 'ManageProjects',
      component: ManageProjects,
      meta: {
        icon: 'phonelink',
        title: 'Manage Projects',
        auth: 1
      }
    },
    {
      path: '/manage/categories',
      name: 'ManageCategories',
      component: ManageCategories,
      meta: {
        icon: 'school',
        title: 'Manage Categories',
        auth: 1
      }
    },

    // panelists
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard,
      meta: {
        icon: 'dashboard',
        title: 'Dashboard',
        auth: 3
      }
    },
    {
      path: '/vote/:id?',
      name: 'Vote',
      component: Vote,
      props: true,
      meta: {
        icon: 'star',
        title: 'Vote',
        auth: 3
      }
    },

    // both
    {
      path: '/votes',
      name: 'Votes',
      component: Votes,
      props: true,
      meta: {
        icon: 'star',
        title: 'All Votes',
        auth: 1
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
