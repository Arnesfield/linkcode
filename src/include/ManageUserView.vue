<template>
<v-list-tile
  ripple
  @click="dialog = true"
> 
  <v-list-tile-content>
    <div class="" v-text="item.name"/>
    <div class="grey--text" v-text="item.username"/>
  </v-list-tile-content>

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
        <v-card-title class="title">Update user</v-card-title>
        <v-card-text>
          <v-text-field
            label="Name"
            placeholder="Enter name"
            v-model="item.name"
            :disabled="loading"
            required
            prepend-icon="person"
            :rules="[ $fRule('required') ]"
          />
          <v-text-field
            label="Username"
            placeholder="Enter username"
            v-model="item.username"
            :disabled="loading"
            required
            prepend-icon="account_circle"
            :rules="[ $fRule('required') ]"
          />
          <v-text-field
            ref="password"
            label="Password"
            placeholder="Enter password"
            tabindex="1"
            v-model="item.password"
            prepend-icon="lock"
            :disabled="loading"
            :append-icon="hidePass ? 'visibility' : 'visibility_off'"
            :append-icon-cb="() => (hidePass = !hidePass)"
            :type="hidePass ? 'password' : 'text'"
            hint="Leave blank to not change password."
            persistent-hint
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
            @click="updateItem"
            :disabled="!form || loading"
          >Update</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>

</v-list-tile>
</template>

<script>
import qs from 'qs'

export default {
  name: 'manage-user-view',
  props: {
    value: Object,
    mode: String
  },
  data: () => ({
    url: '/users/manage',
    item: null,
    form: false,
    dialog: false,
    loading: false,
    backup: null,

    hidePass: true
  }),

  watch: {
    value(e) {
      this.item = e
      this.backup = JSON.parse(JSON.stringify(e))
    },
    item: {
      deep: true,
      handler(e) {
        this.$emit('input', e)
      }
    },
    dialog(e) {
      if (!e) {
        this.$bus.$emit('refresh--btn')
        this.$emit('input', this.backup)
      }
      this.item.password = null
    }
  },

  created() {
    this.item = this.value
    this.item.password = null
    this.backup = JSON.parse(JSON.stringify(this.value))
  },

  methods: {
    updateItem() {
      if (!this.item) {
        return
      }

      let item = this.item
      this.loading = true
      this.$http.post(this.url, qs.stringify({
        id: item.id,
        name: item.name,
        username: item.username,
        password: item.password,
        mode: this.mode
      })).then(res => {
        console.warn(res.data)
        if (!res.data.success) {
          throw new Error('Request failure.')
        }
        this.dialog = false
        this.loading = false
        this.$bus.$emit('snackbar--show', 'Updated successfully.')
        this.$bus.$emit('refresh--btn')
      }).catch(e => {
        console.error(e)
        this.$bus.$emit('snackbar--show', 'Unable to update.')
        this.loading = false
      })
    }
  }
}
</script>
