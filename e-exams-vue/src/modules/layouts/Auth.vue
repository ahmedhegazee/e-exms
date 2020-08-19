<template>
  <div>
    <navbar />
    <slot></slot>
  </div>
</template>

<script>
import Navbar from "../../components/NavBar";
export default {
  components: {
    Navbar
  }
};
</script>

<style scoped>
</style>