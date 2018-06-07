<template>
<v-container
  grid-list-lg
  :style="users.length ? null : {
    display: 'flex',
    height: 'calc(100% - 96px)'
  }"
>

  <div class="full-width">
    <v-text-field
      solo
      label="Search users"
      prepend-icon="search"
      :append-icon="search ? 'close' : undefined"
      :append-icon-cb="() => { search = null }"
      v-model="search"
      class="mb-4"
    />
    <v-layout v-if="!users.length" justify-center align-center>
      <manage-no-data
        class="mb-5"
        msg="No users :("
        :loading="loading"
        :fetch="fetch"
      >
        <v-icon
          slot="icon"
          size="64px"
          class="mb-4"
        >people</v-icon>
        <v-btn
          slot="btn"
          color="primary lighten-1"
          @click="$bus.$emit('user--add')"
        >
          <v-icon>add</v-icon>&nbsp;
          <span>Add user</span>
        </v-btn>
      </manage-no-data>
    </v-layout>
  </div>

  <template v-if="users.length">
    <v-list
      two-line
      class="elevation-1 pa-0"
    >
      <template v-for="(user, i) in users">
        <manage-user-view
          :key="'user-' + i"
          v-model="users[i]"
          :index="i"
          mode="edit"
        />
        <v-divider
          :key="'divider-' + i"
          v-if="users.length != i-1"
        />
      </template>
    </v-list>
  </template>

  <dialog-manage-user ref="dialog"/>

</v-container>
</template>

<script>
import qs from 'qs'
import debounce from 'lodash/debounce'
import ManageNoData from '@/include/ManageNoData'
import ManageUserView from '@/include/ManageUserView'
import DialogManageUser from '@/include/dialogs/DialogManageUser'

export default {
  name: 'manage-users',
  components: {
    ManageNoData,
    ManageUserView,
    DialogManageUser
  },
  data: () => ({
    url: '/users',
    users: [],
    loading: false,
    search: null
  }),

  watch: {
    loading(e) {
      this.$bus.refresh(e)
    },
    search(e) {
      this.fetch()
    }
  },

  created() {
    this.fetch()
    this.$bus.$on('refresh--btn', this.fetch)
    this.$bus.$on('user--add', this.addItem)
  },
  beforeDestroy() {
    this.$bus.$off('refresh--btn', this.fetch)
    this.$bus.$off('user--add', this.addItem)
  },

  methods: {
    addItem() {
      if (this.$refs.dialog) {
        this.$refs.dialog.dialog = true
      }
    },


    fetch: debounce(function(e) {
      this.loading = true
      this.$http.post(this.url, qs.stringify({
        search: this.search,
        noAdmin: true
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.loading = false
        this.users = res.data.users
      }).catch(e => {
        console.error(e)
        this.loading = false
      })
    }, 300)
  }
}
</script>
