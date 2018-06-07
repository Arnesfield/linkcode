<template>
<v-toolbar
  flat
  dark
  :tabs="typeof $bus.tabs[$route.name] !== 'undefined'"
  :absolute="false"
  :fixed="false"
  class="primary lighten-1"
>
  <v-btn icon dark @click="$bus.navToggle">
    <v-icon>{{ $route.meta.icon }}</v-icon>
  </v-btn>
  <v-toolbar-title v-text="title"></v-toolbar-title>

  <v-tabs
    align-with-title
    show-arrows
    color="primary lighten-1"
    v-if="typeof $bus.tabs[$route.name] !== 'undefined' && $bus.tabs[$route.name].tabs"
    v-model="$bus.tabs[$route.name].tab"
    slot="extension">
    <v-tab
      v-for="tab in $bus.tabs[$route.name].items"
      :key="tab">{{ tab }}</v-tab>
  </v-tabs>

</v-toolbar>
</template>

<script>
import BtnRefresh from '@/include/BtnRefresh'

export default {
  name: 'toolbar-content',
  components: {
    BtnRefresh
  },
  computed: {
    title() {
      return this.$bus.toolbar.titleContent ||
        this.$route.meta.title ||
        this.$route.name ||
        'Application'
    }
  },
  methods: {
    checkRoute(arr) {
      if (typeof arr !== 'object') {
        arr = [arr]
      }
      return arr.includes(this.$route.name)
    }
  }
}
</script>
