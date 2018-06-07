<template>
  <v-card>
    <v-card-title class="pb-2">
      <div>
        <div class="title mb-1">{{ item.name }}</div>
        <div class="caption grey--text text--darken-1">Category</div>
      </div>
    </v-card-title>

    <v-list dense>
      <template v-for="(e, i) in item.content">
        <v-divider
          :key="'divider-' + i"
          v-if="item.content.length != i-1"
        />
        <v-list-tile :key="i">
          <v-list-tile-content>{{ e.criterion }}</v-list-tile-content>
          <v-list-tile-action v-if="values[i]" style="overflow: hidden">
            <v-select
              style="transform: translateY(-8px)"
              :items="values[i]"
              v-model="item.content[i].value"
              single-line
              label="Rate"
              required
              :rules="[ $fRule('required') ]"
            />
          </v-list-tile-action>
        </v-list-tile>
      </template>
    </v-list>

  </v-card>
</template>

<script>
import find from 'lodash/find'

export default {
  name: 'category-view',
  props: {
    value: Object
  },

  data: () => ({
    item: null,
    values: {}
  }),

  watch: {
    value(e) {
      this.item = e
    },
    item: {
      deep: true,
      handler(e) {
        this.setValues()
        this.$emit('input', e)
      }
    }
  },

  created() {
    this.item = this.value
  },

  methods: {
    setValues() {
      if (!this.item) {
        return
      }

      this.item.content.forEach((e, index) => {
        if (typeof this.values[index] !== 'undefined') {
          return
        }

        let values = []
        for (let i = e.weight; i > 0; i--) {
          values.push({
            text: i
          })
        }
  
        // add a value prop to index
        if (typeof this.item.content[index].value === 'undefined') {
          this.$set(this.item.content[index], 'value', null)
        } else {
          let value = this.item.content[index].value
          this.$set(this.item.content[index], 'value', find(values, { text: value.text }))
        }
        this.$set(this.values, index, values)
      })
    }
  }
}
</script>
