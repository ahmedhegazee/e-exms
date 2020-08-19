<template>
  <div>
    <BaseSubjectsContainer :subjects="professorSubjects" v-if="professorSubjects" :link="false" />
    <div class="row">
      <div class="col-md-6">
        <h4 class="mb-4">Students improvement level</h4>
        <ScoresAnalysis />
      </div>
      <div class="col-md-6">
        <div class="row header mb-3">
          <h4>Recent Exams</h4>
          <button class="btn btn-primary shadow">See All</button>
        </div>
        <BaseExamsContainer :exams="recentExams" v-if="recentExams" />
      </div>
    </div>
    <BaseUsersSlider :users="topStudents" v-if="topStudents" />
  </div>
</template>

<script>
import ScoresAnalysis from "../components/ScoresAnalysis";

import { mapGetters } from "vuex";
export default {
  components: {
    ScoresAnalysis
  },
  computed: {
    ...mapGetters("professor", [
      "professorSubjects",
      "recentExams",
      "topStudents"
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
