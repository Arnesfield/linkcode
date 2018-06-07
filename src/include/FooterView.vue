<template>
<div>
  
  <div class="primary py-5x white--text">

      <!-- height="688" -->
      <!-- height="688" -->
    <v-jumbotron
      :gradient="gradient"
      class="pa-0 white"
      :height="height"
    >
      <v-parallax
        class="pa-0"
        :height="height"
        style="position: relative;"
        src="./static/images/feu.jpg"
      >

        <v-container
          fluid
          grid-list-md
          style="background-color: rgba(0, 131, 73, 0.24)"
        >
          <v-layout>
            <v-flex offset-xs2 xs1>
              <div class="box primary lighten-1"/>
            </v-flex>
            <v-flex offset-xs1 xs3>
              <div class="box primary darken-1"/>
            </v-flex>
            <v-flex xs1>
              <div class="box primary lighten-2"/>
            </v-flex>
            <v-flex offset-xs1 xs2>
              <div class="box primary"/>
            </v-flex>
          </v-layout>

          <v-layout>
            <v-flex xs1>
              <div class="box primary darken-1"/>
            </v-flex>
            <v-flex xs4>
              <div class="box primary lighten-1"/>
            </v-flex>
            <v-flex offset-xs1 xs3>
              <div class="box primary"/>
            </v-flex>
            <v-flex xs1>
              <div class="box primary lighten-2"/>
            </v-flex>
          </v-layout>

        </v-container>

        <div
          class="full-height full-width dim"
          style="position: absolute;"
        >
          <v-slide-y-reverse-transition>
            <v-container
              fill-height
            >
              <v-layout
                row
                wrap
                align-center
                justify-center
              >
                <div>
                  <v-avatar
                    size="auto"
                    class="pa-2"
                    style="background-color: none;"
                  >
                    <img
                      src="/static/images/logo.png"
                      style="width: 256px; height: auto"
                    />
                  </v-avatar>
                  <!-- <h3 class="headline text-xs-center mono">by &lt;/code&gt;</h3> -->
                </div>
              </v-layout>
            </v-container>
          </v-slide-y-reverse-transition>
        </div>
      </v-parallax>
    </v-jumbotron>
  </div>

  <v-footer
    dark
    :height="null"
    color="primary darken-1"
  >
    <v-container class="mono">
      <v-layout
        row
        wrap
        class="primary--text text--lighten-4 caption"
        align-center
      >
        <v-flex
          justify-center
          align-center
        >Copyright &copy; {{ $autoYear }} LinkCode</v-flex>
        <v-flex
          justify-center
          align-center
          text-sm-right
        >LinkCode Web Application</v-flex>
      </v-layout>
    </v-container>
  </v-footer>

</div>
</template>

<script>
export default {
  name: 'footer-view',
  data: () => ({
    height: 360,
    gradient: 'to right, #008349, #319e61'
  })
}
</script>
