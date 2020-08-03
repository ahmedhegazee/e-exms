<template>
  <img :src="source" />
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    source: {
      required: true,
      type: String
    }
  }
};
</script>

<style scoped>
img {
  border-radius: 50%;
  width: 20px;
  height: 20px;
}
</style>