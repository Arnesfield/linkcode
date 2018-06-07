<template>
<v-dialog
  v-model="dialog"
  :persistent="loading"
  width="360"
  transition="slide-y-reverse-transition"
>
  <v-card>

    <v-progress-linear
      color="accent"
      :active="loading"
      :indeterminate="true"
      height="3"
      class="pb-0 mt-0"
    />

    <v-form v-model="form">
      <v-card-title class="title">Add user</v-card-title>
      <v-card-text>
        <v-text-field
          label="Name"
          placeholder="Enter name"
          v-model="item.name"
          required
          prepend-icon="person"
          :rules="[ $fRule('required') ]"
        />
        <v-text-field
          label="Username"
          placeholder="Enter username"
          v-model="item.username"
          prepend-icon="account_circle"
          required
          :rules="[ $fRule('required') ]"
        />
        <v-text-field
          ref="password"
          label="Password"
          v-model="item.password"
          prepend-icon="lock"
          :disabled="loading"
          :append-icon="hidePass ? 'visibility' : 'visibility_off'"
          :append-icon-cb="() => (hidePass = !hidePass)"
          :type="hidePass ? 'password' : 'text'"
          required
          :rules="[ $fRule('required') ]"
        />
      </v-card-text>

      <v-card-actions>
        <v-spacer/>
        <v-btn
          :disabled="loading"
          @click="dialog = false"
        >Cancel</v-btn>
        <v-btn
          color="primary lighten-1"
          @click="addItem"
          :disabled="!form || loading"
        >Add</v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</v-dialog>
</template>

<script>
import qs from 'qs'

export default {
  name: 'dialog-manage-user',
  data: () => ({
    url: '/users/manage',
    dialog: false,
    loading: false,
    form: false,
    item: {
      name: null,
      username: null,
      password: null
    },
    mode: 'add',

    hidePass: true
  }),

  methods: {
    addItem() {
      if (!this.item) {
        return
      }

      let item = this.item
      this.loading = true
      this.$http.post(this.url, qs.stringify({
        name: item.name,
        username: item.username,
        mode: this.mode
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.dialog = false
        this.loading = false
        this.$bus.$emit('snackbar--show', 'Added successfully.')
        this.$bus.$emit('refresh--btn')
      }).catch(e => {
        console.error(e)
        this.$bus.$emit('snackbar--show', 'Unable to add.')
        this.loading = false
      })
    }
  }
}
</script>
