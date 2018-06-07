<template>
<v-card>
  <v-card-title class="pa-0">
    <div class="full-width">
      <v-text-field
        label="Category"
        placeholder="Enter category name"
        v-model="item.name"
        :rules="[ $fRule('required') ]"
        required
        solo
        class="elevation-1"
      />
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
        <v-list-tile-action>
          <v-text-field
            type="number"
            v-model="item.content[i].weight"
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
export default {
  name: 'manage-category-view',
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
        this.$emit('input', e)
      }
    }
  },

  created() {
    this.item = this.value
  },

  methods: {
  }
}
</script>
