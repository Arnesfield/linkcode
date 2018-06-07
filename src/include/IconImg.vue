<template>
<v-avatar
  class="elevation-1"
  :size="size"
  :color="color"
>
  <template v-if="imgSrc">
    <img
      v-if="imgSrc.isImg"
      :src="imgSrc.text"
      :alt="alt"
    >
    <span
      v-else
      class="white--text"
      :class="{ 'caption': caption }"
    >{{ imgSrc.text }}</span>
  </template>
  <template v-else>
    <span
      class="white--text"
      :class="{ 'caption': caption }"
    >?</span>
  </template>
</v-avatar>  
</template>

<script>
export default {
  name: 'icon-img',
  props: {
    item: {
      type: Object,
      default: null
    },
    size: {
      type: [Number, String],
      default: undefined
    },
    color: {
      type: String,
      default: 'accent'
    },
    caption: {
      type: Boolean,
      default: false
    },
    alt: {
      type: String,
      default: 'avatar'
    }
  },
  computed: {
    imgSrc() {
      let user = this.item
      if (typeof user !== 'object' || user === null) {
        return null
      }
      if (typeof user.img_src !== 'string' || !user.img_src.length) {
        return {
          isImg: false,
          text: user.name.charAt(0).toUpperCase()
        }
      }
      return {
        isImg: true,
        text: this.$wrap.localImg(user.img_src)
      }
    }
  }
}
</script>
