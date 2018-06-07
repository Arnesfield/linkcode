<template>
<v-container>
  <v-tabs-items v-model="$bus.tabs.Votes.tab">
    <v-tab-item
      :key="i"
      v-for="(category, i) in categories"
    >
      <div class="display-1 mt-3">{{ category.name }}</div>
      <div
        v-if="userCount"
        class="grey--text text--darken-1"
      >Total panels: <strong v-text="userCount"/></div>
      <v-list
        two-line
        class="elevation-1 my-3 pa-0"
      >
        <template v-for="(projectId, j) in keyed = keysify(result[category.id])">
          <v-layout
            :key="i + '-' + j"
            class="pa-3"
          >
            <div class="mr-3">{{ j+1 }}</div>
            <div>
              <div>{{ getProject(projectId).name }}</div>
              <div class="grey--text">{{ getProject(projectId).group_name }}</div>
            </div>
            <v-spacer/>
            <div>
              <div class="text-xs-right">
                <div>{{ totalPoints(result[category.id], projectId) }}</div>
                <div
                  class="grey--text"
                >Total Votes: <strong v-text="totalVotes(result[category.id], projectId)"/>
                </div>
              </div>
            </div>
          </v-layout>
          <v-divider
            :key="'divider-' + i + '-' + j"
            v-if="keyed.length-1 != j"
          />
        </template>
      </v-list>
    </v-tab-item>
  </v-tabs-items>
</v-container>
</template>

<script>
import find from 'lodash/find'
import filter from 'lodash/filter'

export default {
  name: 'votes',
  data: () => ({
    url: '/votes',
    votes: [],
    categories: [],
    projects: [],
    userCount: null,
    result: {},
    loading: false
  }),

  watch: {
    loading(e) {
      this.$bus.refresh(e)
    },
    categories: {
      deep: true,
      handler(e) {
        // set tabs
        this.$bus.tabs.Votes.tabs = true
        this.$bus.tabs.Votes.tab = '0'
        this.$bus.tabs.Votes.items = e.reduce((filtered, o) => {
          filtered.push(o.name)
          return filtered
        }, [])
      }
    }
  },

  created() {
    this.fetch()
  },

  methods: {
    keysify(e) {
      return Object.keys(e)
    },

    totalPoints(projectKeyValue, id) {
      let projects = projectKeyValue[id]
      let totalVotesFromAll = projects.reduce((filtered, e) => {
        let total = e.content.reduce((total, f) => {
          return total + Number(f.value.text)
        }, 0)
        let totalAve = total / e.content.length
        return totalAve + filtered
      }, 0)
      let average = projects.length != 0
        ? totalVotesFromAll / projects.length
        : 0
      return average.toFixed(2)
    },

    totalVotes(projectKeyValue, id) {
      let projects = projectKeyValue[id]
      return projects.length
    },

    getProject(id) {
      return find(this.projects, (e) => {
        return Number(e.id) == id
      })
    },

    initVotes() {
      let result = {}
      // get all categories first
      this.categories.forEach(category => {
        let votesPerCategory = this.votes.reduce((filtered, e, i) => {
          let vote = find(e.content, (o) => {
            return Number(o.id) == Number(category.id)
          })

          vote.user_id = Number(e.user_id)
          vote.project_id = Number(e.project_id)

          filtered.push(vote)

          return filtered
        }, [])

        this.$set(result, category.id, votesPerCategory)
      })

      // arrange by projects next
      // per category in result
      Object.keys(result).forEach(catId => {
        let listOfVotesInCategory = result[catId]
        this.$set(result, catId, {})
        Object.keys(this.projects).forEach(projectId => {
          let listOfVotesInProject = filter(listOfVotesInCategory, (o) => {
            return o.project_id == Number(projectId)
          })
          this.$set(result[catId], Number(projectId), listOfVotesInProject)
        })
      })

      this.result = result
    },

    fetch() {
      this.loading = true
      this.$http.post(this.url).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.loading = false
        this.votes = res.data.votes
        this.categories = res.data.categories
        this.projects = res.data.projects
        this.userCount = res.data.userCount
        this.initVotes()
      }).catch(e => {
        this.loading = false
        console.error(e)
      })
    }
  }
}
</script>
