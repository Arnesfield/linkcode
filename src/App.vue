<template>
  <v-app>
    <v-progress-linear
      color="warning"
      height="4"
      :active="$bus.progress.active"
      indeterminate
      style="z-index: 5; position: fixed"
      class="ma-0"
    />
    <navigation v-if="authCheck"/>
    <v-content>
      <toolbar-content v-if="authCheck"/>
      <router-view/>
      <fab/>
      <dialog-confirm/>
    </v-content>
    <toolbar v-if="authCheck"/>
    <snackbar/>
  </v-app>
</template>

<script>
import Fab from '@/include/Fab'
import Toolbar from '@/include/Toolbar'
import ToolbarContent from '@/include/ToolbarContent'
import Navigation from '@/include/Navigation'
import DialogConfirm from '@/include/dialogs/DialogConfirm'
import Snackbar from '@/include/Snackbar'

export default {
  name: 'App',
  components: {
    Fab,
    Toolbar,
    ToolbarContent,
    Navigation,
    DialogConfirm,
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
