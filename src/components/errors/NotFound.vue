<template>
<span>
  <v-toolbar>
    <v-btn icon to="/">
      <v-icon>arrow_back</v-icon>
    </v-btn>
    <v-toolbar-title v-text="'Back'"/>
  </v-toolbar>

  <v-container style="display: flex; height: calc(100% - 64px)">
    <v-layout justify-center align-center>
      <div>
        <!-- <i class="display-2 material-icons">error_outline</i> -->
        <h1 class="display-1 my-4">Error <span class="mono">404</span>. Not found.</h1>
        <div class="subheading mb-2">Sorry, the page that you are looking for does <strong>not</strong> exist :(</div>
      </div>
    </v-layout>
  </v-container>
</span>
</template>

<script>
export default {
  name: 'not-found'
}
</script>
