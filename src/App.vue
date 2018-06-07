<template>
  <v-app>
    <navigation v-if="authCheck"/>
    <v-content>
      <toolbar-content v-if="authCheck"/>
      <router-view/>
    </v-content>
    <toolbar v-if="authCheck"/>
    <snackbar/>
  </v-app>
</template>

<script>
import Toolbar from '@/include/Toolbar'
import ToolbarContent from '@/include/ToolbarContent'
import Navigation from '@/include/Navigation'
import Snackbar from '@/include/Snackbar'

export default {
  name: 'App',
  components: {
    Toolbar,
    ToolbarContent,
    Navigation,
    Snackbar
  },
  computed: {
    authCheck() {
      return this.$bus.authCheck(this.$route.meta.auth)
    }
  },
  watch: {
    $route(to, from) {
      if (this.$bus.authHas(to.meta.auth, [0, -1])) {
        this.$bus.nav.model = null
        this.$bus.nav.miniVariant = false
      }
    }
  },

  created() {
    this.$bus.$on('GET_ROUTE', this.getRoute)
  },
  beforeDestroy() {
    this.$bus.$off('GET_ROUTE', this.getRoute)
  },

  methods: {
    getRoute(emit) {
      this.$bus.$emit(emit, this.$route)
    }
  }
}
</script>
