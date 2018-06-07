<template>
  <div class="text-xs-center" :class="{ 'py-4': !loading }">
    <template v-if="loading">Loading...</template>
    <template v-else>
      <slot name="icon"/>
      <div class="caption mb-2" v-html="msg"></div>
      <slot name="btn"/>
      <v-btn @click="fetch">Refresh</v-btn>
    </template>
  </div>
</template>

<script>
export default {
  name: 'manage-no-data',
  props: {
    msg: {
      type: String,
      default: 'Sorry, nothing to display here :('
    },
    loading: {
      type: Boolean,
      required: true
    },
    fetch: {
      type: Function,
      required: true
    }
  }
}
</script>
