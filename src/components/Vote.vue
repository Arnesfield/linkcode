<template>
<v-container>
  <select-project
    v-model="project"
    :loading="loading"
  />

  <template v-if="project">
    <v-divider class="my-3"/>
    <v-form
      v-model="form"
      v-if="categories.length"
    >
      <v-layout row wrap>
        <v-flex
          xs12
          sm6
          md4
          :key="i"
          v-for="(category, i) in categories"
        >
          <category-view
            v-model="categories[i]"
          />
        </v-flex>
      </v-layout>

      <v-layout class="my-2">
        <v-spacer/>
        <v-btn
          large
          color="primary"
          @click="submit"
          :disabled="!form"
        >
          <v-icon>send</v-icon>
          Submit vote
        </v-btn>
      </v-layout>

    </v-form>
    <v-layout v-else justify-center align-center>
      <manage-no-data
        class="mb-5"
        msg="Unable to load categories :("
        :loading="loading"
        :fetch="fetchCategories"
      />
    </v-layout>
  </template>
</v-container>
</template>

<script>
import qs from 'qs'
import SelectProject from '@/include/SelectProject'
import CategoryView from '@/include/CategoryView'
import ManageNoData from '@/include/ManageNoData'

export default {
  name: 'vote',
  components: {
    SelectProject,
    CategoryView,
    ManageNoData
  },
  data: () => ({
    categoryUrl: '/categories',
    voteUrl: '/vote',
    project: null,
    loading: false,
    form: false,

    categories: []
  }),
  watch: {
    project(e) {
      this.fetchCategories()
    }
  },

  methods: {
    fetchCategories() {
      this.loading = true
      this.categories = []
      this.$http.post(this.categoryUrl, qs.stringify({
        voted: true,
        project_id: this.project.id
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.categories = res.data.categories
        this.loading = false
      }).catch(e => {
        console.error(e)
        this.loading = false
        this.fetchCategories()
      })
    },

    submit() {
      this.loading = true

      if (!this.form) {
        return
      }

      this.$http.post(this.voteUrl, qs.stringify({
        project_id: this.project.id,
        content: JSON.stringify(this.categories),
        status: 1
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.loading = false
        this.$bus.$emit('snackbar--show', 'Vote successfully submitted.')
      }).catch(e => {
        console.error(e)
        this.loading = false
      })
    }
  }
}
</script>
