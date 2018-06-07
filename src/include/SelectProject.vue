<template>
<div>

  <div class="pa-2">
    <v-list class="elevation-1 py-0" two-line>
      <v-list-tile
        ripple
        @click="dialog = true"
      >
        <v-list-tile-action class="thin-action">
          <v-tooltip top>
            <v-btn
              icon
              flat
              slot="activator"
              color="primary"
              @click="dialog = true"
            >
              <v-icon>phonelink</v-icon>
            </v-btn>
            <span>Choose project</span>
          </v-tooltip>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title class="primary--text text--lighten-1">
            <template v-if="selected">{{ selected.name }}</template>
            <template v-else>Select a project</template>
          </v-list-tile-title>
          <v-list-tile-sub-title>
            <template v-if="selected">Project by <strong v-text="selected.group_name"/> selected.</template>
            <template v-else>Select a project</template>
          </v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>

    </v-list>
  </div>

  <v-layout>
    <v-spacer/>
    <v-btn
      color="primary lighten-1"
      @click="dialog = true"
    >
      <v-icon>phonelink</v-icon>&nbsp;
      <span>Choose project</span>
    </v-btn>
  </v-layout>

  <!-- <div v-if="selected" class="mb-5 pr-2">
    <v-subheader>Curriculum&nbsp;<strong v-text="selected.name"/></v-subheader>
  </div> -->

  <!-- dialog -->

  <v-dialog
    v-model="dialog"
    width="640"
    transition="fade-transition"
  >
    <v-text-field
      solo
      ref="searchbar"
      label="Search project"
      prepend-icon="search"
      :append-icon="search ? 'close' : undefined"
      :append-icon-cb="search ? () => { search = null } : undefined"
      v-model="search"
      :loading="dLoading"
    />

    <v-progress-linear
      :active="dLoading"
      :indeterminate="true"
      color="accent"
      class="my-0"
      :height="dLoading ? 3 : 0"
      background-color="white"
    />

    <select-list
      v-model="selectedArr"
      :items="selectedArr"
      id="selected-project-"
      max-height="25vh"
      align-center
      delete-mode
      editable
      :is-selected="(allItems, item) => allItems.indexOf(item) > -1"
    >
      <template
        slot="title"
      >&nbsp;Selected</template>
      <v-layout
        slot="item"
        slot-scope="props"
        align-center
      >
        <v-subheader>
          <div :class="{ 'primary--text text--lighten-1': props.isSelected }">
            <div v-text="props.item.name"/>
            <div class="caption" v-text="props.item.group_name"/>
          </div>
        </v-subheader>

        <v-spacer/>

        <v-tooltip left>
          <v-icon
            color="grey"
            slot="activator"
          >info_outline</v-icon>
          <div
            style="max-width: 420px"
            v-text="props.item.description"
          />
        </v-tooltip>
      </v-layout>
    </select-list>

    <select-list
      radio
      clearable
      v-model="selected"
      :items.sync="projects"
      id="projects-"
      max-height="25vh"
      :is-selected="(items, item) => JSON.stringify(items) == JSON.stringify(item)"
    >
      <template
        slot="title"
      ><strong
        v-text="projects.length"
      />&nbsp;{{ search ? 'Results' : 'Suggested' }}</template>
      <v-layout
        slot="item"
        slot-scope="props"
        align-center
      >
        <v-subheader>
          <div :class="{ 'primary--text text--lighten-1': props.isSelected }">
            <div v-text="props.item.name"/>
            <div class="caption" v-text="props.item.group_name"/>
          </div>
        </v-subheader>

        <v-spacer/>

        <v-tooltip left>
          <v-icon
            color="grey"
            slot="activator"
          >info_outline</v-icon>
          <div
            style="max-width: 420px"
            v-text="props.item.description"
          />
        </v-tooltip>
      </v-layout>
    </select-list>

  </v-dialog>
</div>
</template>

<script>
import qs from 'qs'
import debounce from 'lodash/debounce'
import SelectList from '@/include/SelectList'

export default {
  name: 'select-project',
  components: {
    SelectList
  },
  props: {
    value: Object,
    loading: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    url: '/projects',
    item: null,
    levels: 0,
    remarks: null,

    dialog: false,
    search: null,
    dLoading: false,

    projects: [],

    selected: null,
    selectedArr: []
  }),
  watch: {
    value: {
      deep: true,
      handler(e) {
        this.item = e
      }
    },
    item: {
      deep: true,
      handler(e) {
        this.setInitial()
        this.$emit('input', e)
      }
    },
    loading(e) {
      this.dLoading = e
    },
    dLoading(e) {
      // this.$emit('update:loading', e)
    },

    selected(e) {
      this.selectedArr = e ? [e] : []
      // set this in item
      this.item = e
    },
    selectedArr(e) {
      if (!e.length) {
        this.selected = null
      }
    },

    dialog(e) {
      if (e) {
        this.suggest()
        setTimeout(() => {
          if (this.$refs.searchbar) {
            this.$refs.searchbar.focus()
          }
        })
      } else {
        this.search = null
      }
    },
    search(e) {
      this.dLoading = true
      this.query()
    }
  },

  methods: {
    setInitial() {
      this.selected = this.item
    },

    query: debounce(function(e) {
      const search = this.search
      if (!search) {
        this.projects = []
        this.suggest()
        return
      }

      this.dLoading = true
      this.$http.post(this.url, qs.stringify({
        search: search
      })).then((res) => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.dLoading = false
        this.projects = res.data.projects
      }).catch(e => {
        console.error(e)
        this.dLoading = false
      })
    }, 300),

    suggest() {
      this.dLoading = false

    },
  }
}
</script>
