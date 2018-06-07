// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuetify from 'vuetify'
import axios from 'axios'

import bus from './bus'
import routerCond from './router/cond'
import formRules from './assets/js/formRules'
import base_url from './assets/js/baseURL'
import colors from 'vuetify/es5/util/colors'

import 'vuetify/dist/vuetify.min.css'
import './assets/css/common.css'

const baseURL = base_url + 'api'
const http = axios.create({
  baseURL: baseURL,
  withCredentials: true
})

Vue.use(Vuetify, {
  theme: {
    primary: '#008349', // colors.green.base,
    secondary: '#C7E6C6', // colors.green.lighten4,
    accent: '#FFC218', // colors.yellow.accent2,
    warning: colors.deepOrange.lighten1
  }
})

Vue.config.productionTip = false
Vue.prototype.$http = http
Vue.prototype.$bus = bus
Vue.prototype.$fRule = formRules

routerCond(router, http, bus)

/* eslint-disable no-new */
// before creating instance, check if session exists
document.getElementById('loading').style.display = 'flex'
http.post('/sess').then((res) => {
  document.getElementById('loading').style.display = 'none'
  if (!res.data.success) {
    throw new Error('Request failure.')
  }
  bus.sessionSet(res.data)
  new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>'
  })
}).catch(e => {
  console.error(e)
})
