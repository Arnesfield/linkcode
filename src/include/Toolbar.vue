<template>
  <v-toolbar
    app
    dark
    :clipped-left="$bus.nav.clipped"
    color="primary"
  >
    <v-toolbar-side-icon @click.stop="$bus.navToggle"/>

    <v-toolbar-title
      class="clickable"
      @click="$router.push('/')"
    >
      <v-avatar size="32px" class="mr-1">
        <img src="/static/images/logo.png"/>
      </v-avatar>
      <span v-text="title"></span>
    </v-toolbar-title>

    <template
      v-if="checkRoute('ManageProjects', 'ManageCategories')"
    >
      <v-spacer/>
      <btn-refresh/>
      <v-tooltip bottom>
        <v-btn
          icon
          slot="activator"
          @click="$bus.$emit('save--btn')"
          :loading="$bus.progress.save"
          :disabled="$bus.progress.save || !$bus.progress.saveDisabled"
          color="accent"
        >
          <v-icon>save</v-icon>
        </v-btn>
        <span>Save</span>
      </v-tooltip>
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
  computed: {
    title() {
      return this.$bus.toolbar.title ||
        'LinkCode'
    }
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
