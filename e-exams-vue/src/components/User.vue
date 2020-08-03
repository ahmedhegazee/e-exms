<template>
  <div class="prof col-md-3 d-inline">
    <!-- <img :src="user.image" alt class="mr-4" /> -->
    <BaseImage :source="user.image" alt class="mr-4" />
    <span class="prof-name">{{ user.name }}</span>
    <span class="prof-subject" v-if="user.subject">{{ user.subject }}</span>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
.prof-name {
  font-size: 10pt;
  margin-right: 5%;
}
.prof-subject {
  font-size: 8pt;
}
</style>