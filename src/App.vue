<template>
  <v-app>
    <v-content>
      <router-view/>
    </v-content>
    <snackbar/>
  </v-app>
</template>

<script>
import Snackbar from '@/include/Snackbar'

export default {
  name: 'App',
  components: {
    Snackbar
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
