<template>
  <div>
    <b-alert
      :variant="type"
      class="col-md-10 mb-2"
      style="margin: auto"
      :show="message!==''"
    >{{message}}</b-alert>
  </div>
</template>

<script>
export default {
  props: {
    type: {
      required: true,
      type: String
    },
    message: {
      required: true,
      type: String
    }
  }
};
</script>

<style scoped>
</style>