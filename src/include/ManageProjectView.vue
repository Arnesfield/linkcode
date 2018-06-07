<template>
<v-card>
  <v-card-title class="pa-0">
    <div class="full-width bold">
      <v-text-field
        label="Project name"
        v-model="item.name"
        :rules="[ $fRule('required') ]"
        required
        solo
        class="elevation-1x"
        append-icon="close"
        :append-icon-cb="() => { $emit('delete', index) }"
      />
    </div>
  </v-card-title>

  <v-card-text>
    <v-text-field
      label="Group Name"
      v-model="item.group_name"
      required
      placeholder="Enter group name"
      :rules="[ $fRule('required') ]"
    />
    <v-text-field
      label="Description"
      v-model="item.description"
      required
      multi-line
      placeholder="Enter group name"
      :rules="[ $fRule('required') ]"
    />
  </v-card-text>


</v-card>
</template>

<script>
export default {
  name: 'manage-project-view',
  props: {
    value: Object,
    index: Number
  },
  
  data: () => ({
    item: null,
  }),

  watch: {
    value(e) {
      this.item = e
    },
    item: {
      deep: true,
      handler(e) {
        this.$emit('input', e)
      }
    }
  },

  created() {
    this.item = this.value
  }
}
</script>
