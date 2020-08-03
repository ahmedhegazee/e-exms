<template>
  <div></div>
</template>

<script>
export default {
  mounted() {
    this.$store.dispatch("user/logout");
    this.$router.push({ name: "login" });
  }
};
</script>

<style scoped>
</style>