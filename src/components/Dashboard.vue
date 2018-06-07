<template>
<v-container grid-list-lg>
  <v-subheader>Projects you have voted</v-subheader>
  <v-layout row wrap>
    <template v-for="(project, i) in projects">
      <v-flex
        :key="i"
        xs12
        sm6
      >
        <project-view
          :item="projects[i]"
        />
      </v-flex>
    </template>
  </v-layout>
</v-container>
</template>

<script>
import qs from 'qs'
import ProjectView from '@/include/ProjectView'

export default {
  name: 'dashboard',
  components: {
    ProjectView
  },
  data: () => ({
    url: '/projects',
    projects: [],
    loading: false
  }),

  watch: {
    loading(e) {
      this.$bus.refresh(e)
    }
  },

  created() {
    this.fetch()
  },
  
  methods: {
    fetch() {
      this.loading = true
      this.$http.post(this.url, qs.stringify({
        userSpecific: true
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
    }
  }
}
</script>
