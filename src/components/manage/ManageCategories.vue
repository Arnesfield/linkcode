<template>
<v-container grid-list-lg>
  <v-layout row wrap>
    <template v-for="(category, i) in categories">
      <v-flex
        xs12
        sm6
        md4
        :key="i"
      >
        <manage-category-view
          v-model="categories[i]"
        />
      </v-flex>
    </template>
  </v-layout>
</v-container>
</template>

<script>
import ManageCategoryView from '@/include/ManageCategoryView'

export default {
  name: 'manage-categories',
  components: {
    ManageCategoryView
  },

  data: () => ({
    url: '/categories',
    categories: [],
    loading: false
  }),

  created() {
    this.fetch()
  },

  methods: {
    fetch() {
      this.loading = true
      this.$http.post(this.url).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.loading = false
        this.categories = res.data.categories
      }).catch(e => {
        console.error(e)
        this.loading = false
      })
    }
  }
}
</script>
