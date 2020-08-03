<template>
  <div class="exams row justify-content-between">
    <table>
      <Exam v-for="(exam, index) in exams" :key="index" :exam="exam" />
    </table>
  </div>
</template>

<script>
import Exam from "./Exam";
// import { mapGetters } from "vuex";
export default {
  components: {
    Exam
  },
  props: {
    exams: {
      required: true,
      type: Array
    }
  }
  // computed: {
  //   ...mapGetters("student", ["trainingExamResults"])
  // }
  // mounted() {
  //   this.$store
  //     .dispatch("student/getTrainingExamsResults")
  //     .then(response => (this.exams = response.data.data));
  // },
  // data() {
  //   return {
  //     exams: [
  //       // { id: "EX1", subject: "subject 1", success: true, date: "20/10" },
  //       // { id: "EX2", subject: "subject 2", success: true, date: "20/10" },
  //       // { id: "EX3", subject: "subject 3", success: true, date: "20/10" },
  //       // { id: "EX4", subject: "subject 4", success: false, date: "20/10" },
  //       // { id: "EX5", subject: "subject 5", success: true, date: "20/10" },
  //       // { id: "EX6", subject: "subject 6", success: true, date: "20/10" },
  //       // { id: "EX7", subject: "subject 7", success: true, date: "20/10" },
  //       // { id: "EX8", subject: "subject 8", success: true, date: "20/10" },
  //       // { id: "EX9", subject: "subject 9", success: true, date: "20/10" }
  //     ]
  //   };
  // }
};
</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 80%;
  font-size: 10pt;
}
</style>