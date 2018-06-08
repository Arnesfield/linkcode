<template>
<v-navigation-drawer
  app
  fixed
  :mini-variant="$bus.nav.miniVariant"
  :clipped="clipped"
  :temporary="temporary"
  v-model="$bus.nav.model"
>
  <nav-user/>
  <v-list
    class="pb-0"
    :class="{ 'py-0': i != 0 }"
    :key="i"
    v-if="$bus.authHas(list.auth, $bus.session.auth, -1)"
    v-for="(list, i) in lists"
    :subheader="Boolean(list.header)"
  >
    <v-subheader
      class="grey--text"
      v-if="list.header"
    >{{ list.header }}</v-subheader>
    <template v-for="(item, i) in list.items">
      <v-divider :key="i" v-if="typeof item !== 'object'"/>
      <v-tooltip
        :key="i"
        v-else
        :disabled="!$bus.nav.miniVariant"
        right
      >
        <v-list-tile
          ripple
          slot="activator"
          :to="item.to"
          @keypress.enter="listItemClick(item.click)"
          @click="listItemClick(item.click)"
          :exact-active-class="item.to"
          tabindex="1"
        >
          <v-list-tile-action>
            <v-icon v-html="item.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <span>{{ item.tip || item.title }}</span>
      </v-tooltip>
    </template>
  </v-list>

  <v-list class="pa-0">
    <v-tooltip right :disabled="!$bus.nav.miniVariant">
      <v-list-tile
        ripple
        tabindex="1"
        slot="activator"
        @click="$bus.nav.miniVariant = !$bus.nav.miniVariant">
        <v-list-tile-action>
          <v-btn
            icon
            tabindex="1"
            :ripple="false"
            @click.stop="$bus.nav.miniVariant = !$bus.nav.miniVariant">
            <v-icon v-html="$bus.nav.miniVariant ? 'chevron_right' : 'chevron_left'"/>
          </v-btn>
        </v-list-tile-action>
        <v-list-tile-content>{{ collapseText }}</v-list-tile-content>
      </v-list-tile>
      <span>{{ collapseText }}</span>
    </v-tooltip>
  </v-list>

</v-navigation-drawer>
</template>

<script>
import NavUser from './nav/NavUser'

export default {
  name: 'navigation',
  components: {
    NavUser
  },
  data: () => ({
    logoutUrl: '/logout',
    lists: [
      {
        header: '',
        auth: 3,
        items: [
          { title: 'Dashboard', icon: 'dashboard', to: '/dashboard' },
          { title: 'Vote', icon: 'star', to: '/vote' }
        ]
      },
      {
        header: 'Manage',
        auth: 1,
        items: [
          { title: 'Users', icon: 'account_circle', tip: 'Manage Users', to: '/manage/users' },
          { title: 'Projects', icon: 'phonelink', tip: 'Manage Projects', to: '/manage/projects' },
          { title: 'Categories', icon: 'school', tip: 'Manage Categories', to: '/manage/categories' }
        ]
      },
      {
        header: 'Results',
        auth: 1,
        items: [
          { title: 'All Votes', icon: 'star', tip: 'All Votes', to: '/votes' }
        ]
      },
      // logout
      {
        auth: -1,
        items: [
          '',
          { title: 'Logout', icon: 'exit_to_app', click: 'logout' }
        ]
      }
    ],

    routes: {
      hidden: [],
      short: []
    }
  }),

  computed: {
    collapseText() {
      return this.$bus.nav.miniVariant ? 'Expand' : 'Collapse'
    },
    temporary() {
      return this.checkRoute(this.$route.name, this.routes.hidden)
    },
    clipped() {
      return !this.temporary
    }
  },

  watch: {
    $route(to, from) {
      if (
        !this.checkRoute(to.name, this.routes.hidden) &&
        this.checkRoute(from.name, this.routes.hidden)
      ) {
        this.$bus.nav.model = null
      }

      if (
        this.checkRoute(to.name, this.routes.short) || 
        this.checkRoute(from.name, this.routes.short)
      ) {
        if (this.$bus.nav.model === null || this.$bus.nav.model === true) {
          this.$bus.nav.model = null
          this.$bus.nav.miniVariant = this.checkRoute(to.name, this.routes.short)
        }
      }
    }
  },

  methods: {
    logout() {
      // logout here
      this.$bus.refresh(true)
      this.$http.post(this.logoutUrl).then((res) => {
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.$bus.refresh(false)
        this.$bus.$emit('snackbar--show', 'Logout successfully.')
        this.$bus.sessionCheck(this.$route, this.$http)
      }).catch(e => {
        console.error(e)
        this.$bus.$emit('snackbar--show', 'Unable to logout.')
        this.$bus.refresh(false)
      })
    },

    checkRoute(route, arr) {
      return arr.includes(route)
    },

    listItemClick(e) {
      if (typeof e === 'string') {
        this[e]()
      }
    }
  }
}
</script>
