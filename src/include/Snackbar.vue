<template>
<v-snackbar
  :timeout="timeout"
  :top="y === 'top'"
  :bottom="y === 'bottom'"
  :right="x === 'right'"
  :left="x === 'left'"
  :multi-line="mode === 'multi-line'"
  :vertical="mode === 'vertical'"
  v-model="snackbar"
>
  <span
    class="px-4"
    v-html="text"
    style="padding-top: 14px; padding-bottom: 14px"
  ></span>
  <span style="margin-left: 36px; height: 100%; padding: 6px 16px 6px 0">
    <v-btn
      :key="i"
      v-for="(btn, i) in btns"
      flat
      :icon="btn.icon ? true : false"
      :color="btn.color"
      @click.native="callback(btn, $event)"
      class="px-2"
      style="height: 36px"
    >
      <v-icon v-if="btn.icon">{{ btn.text }}</v-icon>
      <template v-else>{{ btn.text }}</template>
    </v-btn>
  </span>
</v-snackbar>
</template>

<script>
export default {
  name: 'snackbar',
  data: () => ({
    snackbar: false,
    x: 'left',
    y: 'bottom',
    mode: '',
    timeout: 4000,
    text: '',
    btns: []
  }),
  
  created() {
    this.$bus.$on('snackbar--show', this.showSnackbar)
  },
  beforeDestroy() {
    this.$bus.$off('snackbar--show', this.showSnackbar)
  },

  methods: {
    showSnackbar(options) {
      if (this.snackbar) {
        // close current snackbar
        this.snackbar = false
        setTimeout(() => {
          this.createSnackbar(options)
        }, 300)
      } else {
        this.createSnackbar(options)
      }
    },

    callback(btn, e) {
      if (typeof btn.cb === 'function') {
        btn.cb(this, e)
      }
    },
    createSnackbar(options) {
      // if options is string
      if (typeof options === 'string') {
        // make text options
        options = {
          text: options
        }
      }

      const validKeys = [
        { key: 'text', type: 'string', def: '' },
        { key: 'x', type: 'string', def: 'left' },
        { key: 'y', type: 'string', def: 'bottom' },
        { key: 'mode', type: 'string', def: '' },
        { key: 'timeout', type: 'number', def: 4000 },
        {
          key: 'btns', type: 'object', def: [{
            text: 'close',
            icon: false,
            color: 'accent',
            cb: (sb, e) => {
              sb.snackbar = false
            }
          }]
        }
      ]

      // set values
      validKeys.forEach(e => {
        // special check for btns
        if (options && e.key == 'btns' && typeof options.btns !== 'undefined') {
          if (options.btns.constructor.name === 'Array') {
            this.btns = options.btns
          } else if (options.btns.constructor.name === 'Object') {
            this.btns = [options.btns]
          }
          return
        }

        this[e.key] = options && typeof options[e.key] === e.type ? options[e.key] : e.def
      })

      this.snackbar = true
    }
  }
}
</script>
