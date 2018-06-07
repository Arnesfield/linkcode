<template>
<v-container
  grid-list-lg
  :style="projects.length ? null : {
    display: 'flex',
    height: 'calc(100% - 96px)'
  }"
>
  <template v-if="projects.length">
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
  </template>
  <v-layout v-else justify-center align-center>
    <manage-no-data
      class="mb-5"
      msg="You have not voted on any projects yet :("
      :loading="loading"
      :fetch="fetch"
    >
      <v-icon
        slot="icon"
        size="64px"
        class="mb-4"
      >rate_review</v-icon>
      <v-btn
        slot="btn"
        color="primary lighten-1"
        to="/vote"
      >
        <v-icon>star</v-icon>&nbsp;
        <span>Vote now!</span>
      </v-btn>
    </manage-no-data>
  </v-layout>
</v-container>
</template>

<script>
import qs from 'qs'
import ProjectView from '@/include/ProjectView'
import ManageNoData from '@/include/ManageNoData'

export default {
  name: 'dashboard',
  components: {
    ProjectView,
    ManageNoData
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
