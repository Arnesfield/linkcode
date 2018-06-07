<template>
<v-dialog
  v-model="$bus.dialog.global.confirm"
  transition="fade-transition"
  :persistent="loading"
  max-width="320"
>
  <v-card>

    <v-progress-linear
      color="accent"
      :active="loading"
      :indeterminate="true"
      height="3"
      class="pb-0 mt-0"
    />

    <v-card-title class="py-2">
      <div>
        <div
          class="title"
          v-html="title"
        />
        <div
          v-if="subtitle"
          class="caption mt-1 grey--text"
          v-html="subtitle"
        />
      </div>
    </v-card-title>

    <v-card-text v-html="msg" class="py-1"/>
    <v-card-actions>
      <v-spacer/>
      <v-btn
        flat
        :disabled="loading"
        @click="doClose"
        @keypress.enter="doClose"
      >Cancel</v-btn>
      <v-btn
        v-if="btn !== null"
        :color="btn.color || 'primary'"
        flat
        :disabled="loading"
        @click="doConfirm"
        @keypress.enter="doConfirm"
      >{{ btn.text || 'Confirm' }}</v-btn>
    </v-card-actions>

  </v-card>
</v-dialog>
</template>

<script>
export default {
  name: 'dialog-confirm',
  data: () => ({
    item: null,
    title: null,
    subtitle: null,
    msg: null,
    fn: null,
    btn: null,
    loading: false
  }),
  created() {
    this.$bus.$on('watch--dialog.global.confirm', this.watchConfirm)
    this.$bus.$on('dialog--global.confirm.show', this.onShow)
  },
  beforeDestroy() {
    this.$bus.$off('watch--dialog.global.confirm', this.watchConfirm)
    this.$bus.$off('dialog--global.confirm.show', this.onShow)
  },

  methods: {
    watchConfirm(to, from) {
      // if closed, reset
      if (!to) {
        this.item = null
      }
    },
    onShow(props) {
      const validKeys = ['item', 'title', 'subtitle', 'msg', 'fn', 'btn']
      validKeys.forEach(e => {
        this[e] = props[e] ? props[e] : null
      })
      this.$bus.dialog.global.confirm = true
    },

    doConfirm() {
      if (typeof this.fn === 'function') {
        this.loading = true
        this.fn(this.onSuccess, this.onError, this.doClose, this.fn)
      }
    },
    doClose(e) {
      e = typeof e === 'boolean' ? !e : false
      this.$bus.dialog.global.confirm = e
    },
    onSuccess() {
      this.loading = false
      this.doClose()
    },
    onError() {
      this.loading = false
    }
  }
}
</script>
