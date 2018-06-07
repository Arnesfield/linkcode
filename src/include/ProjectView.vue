<template>
<v-card class="pa-0">
  <v-list class="elevation-x1 py-0" two-line>
    <v-list-tile
      ripple
      @click="() => {}"
    >
      <v-list-tile-action class="thin-action">
        <v-btn
          icon
          flat
          color="primary"
          @click="() => {}"
        >
          <v-icon>phonelink</v-icon>
        </v-btn>
      </v-list-tile-action>
      <v-list-tile-content>
        <v-list-tile-title class="primary--text text--lighten-1">
          <template>{{ item.name }}</template>
        </v-list-tile-title>
        <v-list-tile-sub-title>
          <template>Project by <strong v-text="item.group_name"/> selected.</template>
        </v-list-tile-sub-title>
      </v-list-tile-content>
      <v-list-tile-action>
        <v-tooltip top>
          <v-btn
            icon
            flat
            slot="activator"
            color="primary"
            :to="'/vote/' + item.id"
          >
            <v-icon>rate_review</v-icon>
          </v-btn>
          <span>Edit vote</span>
        </v-tooltip>
      </v-list-tile-action>
    </v-list-tile>

  </v-list>
  <template v-if="item && item.description">
    <v-divider/>
    <v-card-text>
      <div class="caption grey--text">Description</div>
      <div v-text="item.description"></div>
    </v-card-text>
  </template>
</v-card>
</template>

<script>
export default {
  name: 'project-view',
  props: {
    item: Object
  }
}
</script>
