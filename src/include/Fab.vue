<template>
<v-speed-dial
  v-model="$bus.fab.model"
  :value="fab !== null"
  :open-on-hover="true"
  fixed
  bottom
  right
>
  <template v-if="fab !== null">
    <v-tooltip left slot="activator" :disabled="!fab.tip">
      <v-btn
        slot="activator"
        v-model="$bus.fab.model"
        :color="fab.color"
        @click="onFabClick(fab.click, $event)"
        dark
        fab>
        <v-icon>{{ fab.before }}</v-icon>
        <v-icon v-if="fab.btns !== null">{{ fab.after }}</v-icon>
      </v-btn>
      <span>{{ fab.tip }}</span>
    </v-tooltip>
    <template v-if="fab.btns !== null" v-for="(btn, i) in fab.btns">
      <v-tooltip :key="i" left>
        <v-btn
          slot="activator"
          :to="typeof btn.to === 'string' ? btn.to : undefined"
          @click="typeof btn.cb === 'string' ? $bus.$emit(btn.cb, $event) : undefined"
          :color="typeof btn.color === 'string' ? btn.color : undefined"
          :dark="typeof btn.dark === 'boolean' ? btn.dark : false"
          small
          fab>
          <v-icon>{{ btn.icon }}</v-icon>
        </v-btn>
        <span>{{ btn.tip }}</span>
      </v-tooltip>
    </template>
  </template>
</v-speed-dial>
</template>

<script>
export default {
  name: 'fab',
  computed: {
    fab() {
      return this.$bus.fab.inst[this.$route.name] || null
    }
  },

  methods: {
    onFabClick(emit, e) {
      if (typeof emit === 'string') {
        this.$bus.$emit(emit, e)
      }
    }
  }
}
</script>
