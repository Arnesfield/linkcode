<template>
  <div class="bg" style="background-image: url('./static/images/bg-2.sm.jpg')">
    <v-container fluid class="no-bg dim pa-3">
      <icon-img :item="$bus.session.user"/>
    </v-container>
    <v-list class="no-bg dim">
      <v-list-tile>
        <v-list-tile-content>
          <v-list-tile-title class="title white--text">{{ fullname }}</v-list-tile-title>
          <v-list-tile-sub-title class="grey--text text--lighten-3">{{ username }}</v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </div>
</template>

<script>
import IconImg from '@/include/IconImg'

export default {
  name: 'nav-user',
  components: {
    IconImg
  },
  computed: {
    fullname() {
      let user = this.$bus.session.user
      return this.$wrap.fullname(user)
    },
    username() {
      let user = this.$bus.session.user
      return user && user.username ? user.username : ''
    }
  }
}
</script>
