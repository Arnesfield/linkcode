<template>
<v-card width="100%" style="background-color: rgba(255, 255, 255, 0.86)">
  <v-progress-linear
    height="4"
    indeterminate
    color="warning"
    :active="loading"/>
  <div class="px-4 pb-4 pt-2">
    <v-card-title primary-title>
      <div>
        <div class="headline">Sign In</div>
        <span class="grey--text">link code panelist</span>
      </div>
    </v-card-title>
    <v-card-title>
      <v-form class="full-width">
        <v-text-field
          ref="username"
          type="text"
          label="Username"
          tabindex="1"
          v-model="username"
          prepend-icon="account_circle"
          :disabled="loading"
          :error-messages="usernameError"
          @keypress.enter="submit"
        />
        <v-text-field
          ref="password"
          label="Password"
          tabindex="1"
          v-model="password"
          prepend-icon="lock"
          :disabled="loading"
          :append-icon="hidePass ? 'visibility' : 'visibility_off'"
          :append-icon-cb="() => (hidePass = !hidePass)"
          :type="hidePass ? 'password' : 'text'"
          :error-messages="passwordError"
          @keypress.enter="submit"
        />
      </v-form>
    </v-card-title>
    <v-card-actions>
      <v-spacer/>
      <v-btn
        tabindex="1"
        color="primary"
        :disabled="loading"
        @click="submit"
        @keypress.enter="submit"
        type="submit"
      >Login</v-btn>
    </v-card-actions>
  </div>

</v-card>
</template>

<script>
import qs from 'qs'

export default {
  name: 'login-form',
  data: () => ({
    url: '/login',
    username: null,
    password: null,
    usernameError: [],
    passwordError: [],
    // view
    loading: false,
    hidePass: true
  }),

  methods: {
    submit() {
      this.loading = true
      this.usernameError = []
      this.passwordError = []
      // request here
      this.$http.post(this.url, qs.stringify({
        username: this.username,
        password: this.password,
      })).then((res) => {
        if (!res.data.success) {
          this.loading = false
          this.usernameError = ''
          this.passwordError = res.data.error
          return
        }

        this.$bus.$emit('snackbar--show', 'Login successfully.')
        this.$bus.sessionCheck(this.$route, this.$http)
      }).catch(e => {
        console.error(e)
        this.loading = false
        this.usernameError = ''
        this.passwordError = 'An error occurred.'
      })
    }
  }
}
</script>
