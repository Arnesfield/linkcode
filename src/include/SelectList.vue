<template>
<span v-if="dItems.length">
  <v-list class="pa-0 mt-2">
    <v-list-tile class="px-0">
      <v-list-tile-content>
        <v-subheader class="white pl-0">
          <slot name="title"/>
        </v-subheader>
      </v-list-tile-content>
      <v-list-tile-action v-if="clearable">
        <v-tooltip top>
          <v-btn
            icon
            small
            slot="activator"
            @click="dItems = []"
          >
            <v-icon small>close</v-icon>
          </v-btn>
          <span>Clear</span>
        </v-tooltip>
      </v-list-tile-action>
    </v-list-tile>
  </v-list>
  <div style="overflow-y: scroll;" :style="{ 'max-height': maxHeight }">
    <v-list class="pt-0 mt-0">
      <template v-for="(item, i) in dItems">
        <v-list-tile
          :ripple="!editable"
          :key="'tile-' + i"
          @click="() => {}"
          class="tile-select"
        >
          <v-layout
            class="full-height"
            :class="{ 'pl-3': !deleteMode }"
            :align-center="alignCenter"
          >
            <v-tooltip top v-if="deleteMode">
              <v-btn
                icon
                small
                flat
                slot="activator"
                @click="selected.splice(i, 1)"
              >
                <v-icon small color="error">close</v-icon>
              </v-btn>
              <span>Remove</span>
            </v-tooltip>
            <input
              v-else-if="radio"
              type="radio"
              :value="item"
              :id="id + i"
              v-model="selected"
              :style="{ 'margin-top': !editable ? '18px' : '14px' }"
              class="mr-2"
            >
            <input
              v-else
              type="checkbox"
              :value="item"
              :id="id + i"
              v-model="selected"
              :style="{ 'margin-top': !editable ? '18px' : '14px' }"
              class="mr-2"
            >
            <label
              class="clickable full-width full-height pr-3"
              style="display: block;"
              :for="!editable ? id + i : undefined"
              :class="{ 'primary--text text--lighten-1': selectedCheck(item) }"
            >
              <slot
                name="item"
                :item="item"
                :index="i"
                :is-selected="selectedCheck(item)"
              />
            </label>
          </v-layout>
        </v-list-tile>
      </template>
    </v-list>
  </div>
</span>
</template>

<script>
export default {
  name: 'select-list',
  props: {
    items: Array,
    value: [Object, Array],
    id: String,
    isSelected: Function,
    maxHeight: {
      type: String,
      default: '50vh'
    },
    editable: {
      type: Boolean,
      default: false
    },
    deleteMode: {
      type: Boolean,
      default: false
    },
    clearable: {
      type: Boolean,
      default: false
    },
    radio: {
      type: Boolean,
      default: false
    },
    alignCenter: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    selected: null,
    dItems: []
  }),
  watch: {
    value: {
      deep: true,
      handler(e) {
        this.selected = e
      }
    },
    selected: {
      deep: true,
      handler(e) {
        this.$emit('input', e)
      }
    },
    items: {
      deep: true,
      handler(e) {
        this.dItems = e
      }
    },
    dItems: {
      deep: true,
      handler(e) {
        this.$emit('update:items', e)
      }
    }
  },
  created() {
    this.selected = this.value
    this.dItems = this.items
  },
  methods: {
    selectedCheck(item) {
      return this.isSelected(this.selected, item)
    }
  }
}
</script>
