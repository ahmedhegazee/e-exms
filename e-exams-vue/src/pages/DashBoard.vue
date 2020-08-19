<template>
  <!-- <Main> -->
  <component :is="component" />
  <!-- </Main> -->
</template>

<script>
import StudentDashboard from "../modules/student/pages/Dashboard";
import ProfessorDashboard from "../modules/professor/pages/Dashboard";
// import Main from "../modules/layouts/Main";
import store from "../store/store";
import NProgress from "nprogress";
export default {
  components: {
    student: StudentDashboard,
    professor: ProfessorDashboard
    // Main
  },
  mounted() {
    if (this.$store.getters["user/isStudent"]) this.component = "student";
    if (this.$store.getters["user/isProfessor"]) this.component = "professor";
  },
  beforeRouteEnter(to, from, next) {
    NProgress.start();
    // setTimeout(function() {
    if (store.getters["user/isStudent"]) {
      store
        .dispatch("student/getTrainingExamsResults")
        .catch(() => next({ name: "network-issue" }));
      store
        .dispatch("student/getProfessorsData")
        .catch(() => next({ name: "network-issue" }));
      store
        .dispatch("student/getSubjects")
        .catch(() => next({ name: "network-issue" }));
      NProgress.done();
      next();
    }
    if (store.getters["user/isProfessor"]) {
      store
        .dispatch("professor/getRecentExams")
        .catch(() => next({ name: "network-issue" }));
      store
        .dispatch("professor/getSubjects")
        .catch(() => next({ name: "network-issue" }));
         store
        .dispatch("professor/getTopStudents")
        .catch(() => next({ name: "network-issue" }));
      NProgress.done();
      next();
    }
    // }, 2000);
    next();
  },
  data() {
    return {
      component: ""
    };
  }
};
</script>

<style scoped>
</style>