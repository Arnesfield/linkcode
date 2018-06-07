<template>
<v-container
  grid-list-lg
  :style="categories.length ? null : {
    display: 'flex',
    height: 'calc(100% - 96px)'
  }"
>
  <v-form class="full-width" v-if="categories.length">
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
            :index="i"
            @delete="deleteItem"
          />
        </v-flex>
      </template>
    </v-layout>
  </v-form>
  <v-layout v-else justify-center align-center>
    <manage-no-data
      class="mb-5"
      msg="No categories :("
      :loading="loading"
      :fetch="fetch"
    >
      <v-icon
        slot="icon"
        size="64px"
        class="mb-4"
      >school</v-icon>
      <v-btn
        slot="btn"
        color="primary lighten-1"
        @click="addItem"
      >Add category</v-btn>
    </manage-no-data>
  </v-layout>
</v-container>
</template>

<script>
import qs from 'qs'
import ManageCategoryView from '@/include/ManageCategoryView'
import ManageNoData from '@/include/ManageNoData'

export default {
  name: 'manage-categories',
  components: {
    ManageCategoryView,
    ManageNoData
  },

  data: () => ({
    url: '/categories',
    saveUrl: '/categories/save',
    categories: [],
    loading: false
  }),

  watch: {
    loading(e) {
      this.$bus.refresh(e)
    }
  },

  created() {
    this.fetch()
    this.$bus.$on('category--add', this.addItem)
    this.$bus.$on('save--btn', this.submit)
    this.$bus.$on('refresh--btn', this.fetch)
  },
  beforeDestroy() {
    this.$bus.$off('category--add', this.addItem)
    this.$bus.$off('save--btn', this.submit)
    this.$bus.$off('refresh--btn', this.fetch)
  },

  methods: {
    addItem() {
      this.categories.push({
        name: null,
        content: [],
        status: 1
      })
    },
    deleteItem(i) {
      this.categories.splice(i, 1)
    },

    submit() {
      this.$bus.save(true)
      this.$http.post(this.saveUrl, qs.stringify({
        categories: JSON.stringify(this.categories)
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.$bus.$emit('snackbar--show', 'Updated successfully.')
        this.$bus.save(false)
      }).catch(e => {
        console.error(e)
        this.$bus.$emit('snackbar--show', 'Unable to update.')
        this.$bus.save(false)
      })
    },

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
