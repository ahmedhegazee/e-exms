<template>
  <div>
    <div class="row">
      <h4 class="row container-title">Questions Bank</h4>
      <div class="row pt-3 pb-5 pr-2 pl-2 items-container">
        <Subject v-for="(subject, index) in subjects" :key="index" :subject="subject" :link="link" />
      </div>
    </div>
  </div>
</template>

<script>
import Subject from "./Subject";
export default {
  components: {
    Subject
  },
  props: {
    subjects: {
      required: true,
      type: Array
    },
    link: {
      type: Boolean,
      default: true
    }
  }
  // mounted() {
  //   this.$store.dispatch("student/getSubjects");
  // },
  // computed: {
  //   subjects() {
  //     return this.$store.getters["student/studentSubjects"];
  //   }
  // }
  // data() {
  //   return {
  //     subjects: [
  //       // { name: "subject 1", questions: 130 },
  //       // { name: "subject 2", questions: 130 },
  //       // { name: "subject 3", questions: 130 },
  //       // { name: "subject 4", questions: 130 },
  //       // { name: "subject 5", questions: 130 },
  //       // { name: "subject 6", questions: 130 },
  //       // { name: "subject 7", questions: 130 }
  //     ]
  //   };
  // }
};
</script>

<style scoped>
</style>