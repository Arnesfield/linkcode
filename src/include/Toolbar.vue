<template>
  <v-toolbar
    app
    dark
    :clipped-left="$bus.nav.clipped"
    color="primary"
  >
    <v-toolbar-side-icon @click.stop="$bus.navToggle"/>

    <v-flex xs1 sm1 md2>
      <v-toolbar-title
        class="clickable"
        @click="$router.push('/')"
      >
        <v-avatar size="32px" class="mr-1">
          <img src="/static/images/logo.png"/>
        </v-avatar>
        <span class="hidden-sm-and-down">LinkCode</span>
      </v-toolbar-title>
    </v-flex>

    <template
      v-if="checkRoute('')"
    >
      <v-spacer/>
      <btn-refresh/>
    </template>

  </v-toolbar>
</template>

<script>
import BtnRefresh from '@/include/BtnRefresh'

export default {
  name: 'toolbar',
  components: {
    BtnRefresh
  },
  methods: {
    checkRoute(...arr) {
      // if (typeof arr === 'string') {
      //   arr = [arr]
      // }
      return arr.includes(this.$route.name)
    }
  }
}
</script>
