<template>
<v-container
  grid-list-lg
  :style="projects.length ? null : {
    display: 'flex',
    height: 'calc(100% - 96px)'
  }"
>

  <div class="full-width">
    <v-text-field
      solo
      label="Search projects"
      prepend-icon="search"
      :append-icon="search ? 'close' : undefined"
      :append-icon-cb="() => { search = null }"
      v-model="search"
      class="mb-4"
    />
    <v-layout v-if="!projects.length" justify-center align-center>
      <manage-no-data
        class="mb-5"
        msg="No projects :("
        :loading="loading"
        :fetch="fetch"
      />
    </v-layout>
  </div>

  <template v-if="projects.length">
    <v-divider class="my-3"/>
    <v-form v-model="form">
      <v-layout row wrap>
        <template v-for="(project, i) in projects">
          <v-flex
            xs12
            sm6
            :key="i"
          >
            <manage-project-view
              v-model="projects[i]"
              :index="i"
              @delete="deleteItem"
            />
          </v-flex>
        </template>
      </v-layout>
    </v-form>
  </template>

</v-container>
</template>

<script>
import qs from 'qs'
import debounce from 'lodash/debounce'
import ManageProjectView from '@/include/ManageProjectView'
import ManageNoData from '@/include/ManageNoData'

export default {
  name: 'manage-projects',
  components: {
    ManageProjectView,
    ManageNoData
  },
  data: () => ({
    url: '/projects',
    submitUrl: '/projects/save',
    projects: [],
    search: null,
    loading: false,
    form: false
  }),

  watch: {
    loading(e) {
      this.$bus.refresh(e)
    },
    search(e) {
      this.fetch()
    },
    form(e) {
      this.$bus.disableSave(e)
    }
  },

  created() {
    this.fetch()
    this.$bus.disableSave(this.form)
    this.$bus.$on('project--add', this.addItem)
    this.$bus.$on('refresh--btn', this.fetch)
    this.$bus.$on('save--btn', this.submit)
  },
  beforeDestroy() {
    this.$bus.$off('project--add', this.addItem)
    this.$bus.$off('refresh--btn', this.fetch)
    this.$bus.$off('save--btn', this.submit)
  },

  methods: {
    addItem() {
      this.projects.push({
        name: null,
        group_name: null,
        description: null,
        status: 1
      })
    },
    deleteItem(i) {
      this.projects.splice(i, 1)
    },

    submit() {
      if (!this.projects) {
        return
      }

      this.$bus.save(true)
      this.$http.post(this.submitUrl, qs.stringify({
        projects: JSON.stringify(this.projects)
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.$bus.save(false)
        this.$bus.$emit('snackbar--show', 'Updated successfully.')
      }).catch(e => {
        console.error(e)
        this.$bus.$emit('snackbar--show', 'Unable to update.')
        this.$bus.save(false)
      })
    },

    fetch: debounce(function(e) {
      this.loading = true
      this.$http.post(this.url, qs.stringify({
        search: this.search
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.loading = false
        this.projects = res.data.projects
      }).catch(e => {
        console.error(e)
        this.loading = false
      })
    }, 300)
  }
}
</script>
