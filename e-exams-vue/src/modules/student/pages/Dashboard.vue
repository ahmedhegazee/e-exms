<template>
  <div>
    <!-- <Main> -->
    <BaseSubjectsContainer :subjects="studentSubjects" v-if="studentSubjects" />
    <div class="row">
      <div class="col-md-6">
        <h4 class="mb-4">Scores Analysis</h4>
        <ScoresAnalysis />
      </div>
      <div class="col-md-6">
        <div class="row header mb-3">
          <h4>Recent Exams</h4>
          <button class="btn btn-primary shadow">See All</button>
        </div>
        <BaseExamsContainer :exams="trainingExamResults" v-if="trainingExamResults" />
      </div>
    </div>
    <!-- <ProfessorsContainer /> -->
    <BaseUsersSlider :users="professors" v-if="professors" />
    <!-- </Main> -->
  </div>
</template>

<script>
// import SubjectsContainer from "../components/SubjectsContainer";
// import Main from "../../layouts/Main";
import ScoresAnalysis from "../components/ScoresAnalysis";
// import ProfessorsContainer from "../components/ProfessorsContainer";
// import ExamsContainer from "../components/ExamsContainer";
import { mapGetters } from "vuex";
export default {
  components: {
    // SubjectsContainer,
    // Main,
    ScoresAnalysis
    // ProfessorsContainer,
    // ExamsContainer
  },
  computed: {
    ...mapGetters("student", [
      "professors",
      "studentSubjects",
      "trainingExamResults"
    ])
  }
};
</script>

<style scoped>
img {
  height: 60px;
  width: 30%;
}
.subjects {
  overflow-x: scroll;
  width: 98%;
  flex-wrap: nowrap;
}

h4 {
  font-size: 12pt;
  font-weight: 600;
}

.header {
  padding-left: 10px;
  justify-content: space-between;
}
.header .btn {
  margin-right: 20%;
  color: #aaa;
  border: 0;
  font-size: 10pt;
  padding: 5px 20px;
}

.btn {
  background-color: #fff;
  border-radius: 15px;
}
</style>
