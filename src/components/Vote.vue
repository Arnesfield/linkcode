<template>
<v-container>
  <select-project
    v-model="project"
    :loading="loading"
  />
</v-container>
</template>

<script>
import SelectProject from '@/include/SelectProject'

export default {
  name: 'vote',
  components: {
    SelectProject
  },
  data: () => ({
    project: null,
    loading: false
  })
}
</script>
