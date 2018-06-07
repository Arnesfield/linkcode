<template>
<v-card>
  <v-card-title class="pa-0">
    <div class="full-width bold">
      <v-text-field
        label="Category name"
        v-model="item.name"
        :rules="[ $fRule('required') ]"
        required
        solo
        class="elevation-1x"
        append-icon="close"
        :append-icon-cb="() => { $emit('delete', index) }"
      />
    </div>
  </v-card-title>

  <v-list dense>
    <v-list-tile>
      <v-list-tile-content>
        <strong>Criterion</strong>
      </v-list-tile-content>
      <v-list-tile-action>
        <strong style="width: 64px">Weight</strong>
      </v-list-tile-action>
    </v-list-tile>
    <template v-for="(e, i) in item.content">
      <v-divider
        :key="'divider-' + i"
        v-if="item.content.length != i-1"
      />
      <v-list-tile :key="'tile-' + i">
        <v-list-tile-action class="thin-36">
          <v-tooltip top>
            <v-btn
              icon
              slot="activator"
              small
              @click="() => { removeCriterion(i) }"
            >
              <v-icon
                small
                color="error"
              >close</v-icon>
            </v-btn>
            <span>Remove</span>
          </v-tooltip>
        </v-list-tile-action>
        <v-list-tile-content class="pr-2">
          <v-text-field
            placeholder="Enter criterion"
            style="transform: translateY(-12px)"
            v-model="e.criterion"
            :required="true"
            :rules="[ $fRule('required') ]"
          />
        </v-list-tile-content>
        <v-list-tile-action>
          <div style="width: 64px">
            <v-text-field
              style="transform: translateY(-8px)"
              type="number"
              placeholder="Weight"
              v-model="item.content[i].weight"
              required
              :rules="[ $fRule('required'), $fRule('min', null, 1), $fRule('max', null, 20) ]"
            />
          </div>
        </v-list-tile-action>
      </v-list-tile>
    </template>

    <!-- add -->

    <v-list-tile>
      <v-btn
        small
        block
        color="primary lighten-1"
        @click="addCriterion"
      >
        <v-icon>add</v-icon>
        <span>Add criterion</span>
      </v-btn>
    </v-list-tile>
  </v-list>

</v-card>
</template>

<script>
export default {
  name: 'manage-category-view',
  props: {
    value: Object,
    index: Number
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
    addCriterion() {
      this.item.content.push({
        criterion: null,
        weight: 10
      })
    },
    removeCriterion(i) {
      this.item.content.splice(i, 1)
    }
  }
}
</script>
