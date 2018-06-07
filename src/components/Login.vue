<template>
<div>

  <v-jumbotron
    :height="height"
    class="pa-0 white"
  >
    <v-parallax
      class="pa-0"
      :height="height"
      style="position: relative;"
      src="./static/images/ebulletin.png"
    >
      <div
        class="full-height full-width dim-2"
        style="position: absolute;"
      >
        <v-slide-y-reverse-transition>
          <v-container
            fill-height
            class="pa-0"
            v-show="anim.title"
          >
            <v-layout
              row wrap
            >

              <v-flex
                xs12
                sm6
              >
                <v-layout
                  row
                  wrap
                  align-center
                  justify-center
                >
                  <div>
                    <h3 class="display-3">
                      <strong
                        class="mono"
                        style="letter-spacing: 6px"
                      >LINKCODE</strong>
                    </h3>
                    <h6 class="title mt-1">
                      <template>ITFair</template>
                      <strong
                        class="white primary--text px-2 py-1"
                      >2k18</strong>
                    </h6>
                  </div>
                </v-layout>
              </v-flex>
              <v-flex
                xs12
                sm6
              >
                
                <v-layout
                  row
                  wrap
                  align-center
                  justify-center
                >
                  <v-flex xs12 sm12 md12 lg9 class="pa-2">
                    <login-form/>
                  </v-flex>
                </v-layout>
              </v-flex>

            </v-layout>

          </v-container>
        </v-slide-y-reverse-transition>
      </div>
    </v-parallax>
  </v-jumbotron>

  <footer-view/>
  
</div>
</template>

<script>
import LoginForm from '@/include/LoginForm'
import FooterView from '@/include/FooterView'

export default {
  name: 'login',
  components: {
    LoginForm,
    FooterView
  },
  data: () => ({
    gradient: 'to right, #008349, #319e61',
    height: 780,
    anim: {
      title: false
    }
  }),

  created() {
    
  },

  mounted() {
    setTimeout(() => {
      this.anim.title = true
    }, 500)
  }
}
</script>
