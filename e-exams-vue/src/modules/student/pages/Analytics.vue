<template>
  <div class="row">
    <div class="col-md-4">
      <h2 class="item-title mb-4">Quick Analysis</h2>
      <div class="analysis-container" v-if="currentSubject!=null">
        <div
          class="analysis mb-4"
          v-for="(subject, index) in studentSubjects"
          :key="index"
          :class="{active:currentSubject.id==subject.id}"
          @click="currentSubject=subject"
        >
          <div class="row">
            <i class="fas fa-file-signature"></i>
            <!-- <span class="item-title mb-1">{{ subject.name }}</span> -->
            <span class="item-title mb-1 ml-2">{{subject.name}}</span>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <svg
                class="circle-chart"
                viewBox="0 0 33.83098862 33.83098862"
                width="90"
                height="90"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle
                  class="circle-chart__background"
                  stroke="#ff7271"
                  stroke-width="2"
                  fill="none"
                  cx="16.91549431"
                  cy="16.91549431"
                  r="15.91549431"
                />
                <text
                  x="13"
                  y="18"
                  style="font-size:6pt;"
                >{{subject.pass_exams+subject.failed_exams}}</text>
                <text x="10" y="23" style="font-size:2pt;" fill="#acacac">total exams</text>
                <circle
                  class="circle-chart__circle"
                  stroke="#1bd371"
                  stroke-width="2"
                  :stroke-dasharray="[getPercent(subject.pass_exams,subject.failed_exams),100]"
                  stroke-linecap="round"
                  fill="none"
                  cx="16.91549431"
                  cy="16.91549431"
                  r="15.91549431"
                />
              </svg>
              <div class="row percentages">
                <span class="question-category green d-inline"></span>
                <span
                  class="percent ml-1 mr-1"
                >{{getPercent(subject.pass_exams,subject.failed_exams)}}%</span>
                <span>pass</span>
              </div>
              <div class="row percentages">
                <span class="question-category red d-inline"></span>
                <span
                  class="percent ml-1 mr-1"
                >{{getPercent(subject.failed_exams,subject.pass_exams)}}%</span>
                <span>fail</span>
              </div>
            </div>
            <div class="col-6">
              <svg
                class="circle-chart"
                viewBox="0 0 33.83098862 33.83098862"
                width="90"
                height="90"
                xmlns="http://www.w3.org/2000/svg"
              >
                <text
                  x="13"
                  y="18"
                  style="font-size:6pt;"
                >{{subject.correct_answers+subject.wrong_answers}}</text>
                <text x="8" y="23" style="font-size:2pt;" fill="#acacac">total questions</text>
                <circle
                  class="circle-chart__background"
                  stroke="#ff7271"
                  stroke-width="2"
                  fill="none"
                  cx="16.91549431"
                  cy="16.91549431"
                  r="15.91549431"
                />
                <circle
                  class="circle-chart__circle"
                  stroke="#1bd371"
                  stroke-width="2"
                  :stroke-dasharray="[getPercent(subject.correct_answers,subject.wrong_answers),100]"
                  stroke-linecap="round"
                  fill="none"
                  cx="16.91549431"
                  cy="16.91549431"
                  r="15.91549431"
                />
              </svg>
              <div class="row percentages">
                <span class="question-category green d-inline"></span>
                <span
                  class="percent ml-1 mr-1"
                >{{getPercent(subject.correct_answers,subject.wrong_answers)}}%</span>
                <span>correct</span>
              </div>
              <div class="row percentages">
                <span class="question-category red d-inline"></span>
                <span
                  class="percent ml-1 mr-1"
                >{{getPercent(subject.wrong_answers,subject.correct_answers)}}%</span>
                <span>wrong</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <h2 class="item-title mb-4">Wrong Answers</h2>
      <QuestionsContainer
        v-if="currentSubject!=null"
        :wrongAnswers="true"
        :chapter="{title:currentSubject.name,id:currentSubject.id}"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import QuestionsContainer from "../../subject/components/QuestionsContainer";
export default {
  components: {
    QuestionsContainer
  },
  computed: {
    ...mapGetters("student", ["studentSubjects"])
  },
  methods: {
    getPercent(firstValue, secondValue) {
      if (firstValue == 0) return 0;
      return Math.round((firstValue / (firstValue + secondValue)) * 100);
    }
  },
  mounted() {
    if (!this.studentSubjects) {
      this.$store.dispatch("student/getSubjects").then(() => {
        this.currentSubject = this.studentSubjects[0];
      });
    } else {
      this.currentSubject = this.studentSubjects[0];
    }
  },
  data() {
    return {
      currentSubject: null
    };
  }
};
</script>

<style scoped>
.item-title {
  font-weight: 200;
}
.fa-file-signature {
  color: #1bd371;
}
.analysis-container {
  overflow-y: scroll;
  height: 90vh;
}
.analysis {
  background-color: #fff;
  border-radius: 15px;
  padding: 20px 30px;
}
.circle-chart__circle {
  transform: rotate(-90deg);
  transform-origin: center;
  animation: circle-chart-fill 2s reverse;
}
@keyframes circle-chart-fill {
  to {
    stroke-dasharray: 0 100;
  }
}
.question-category {
  height: 10px;
  width: 10px;
  border-radius: 1px;
}
.red {
  background-color: #ff7271;
}
.green {
  background-color: #1bd371;
}
.yellow {
  background-color: #ffe96f;
}
.percentages {
  padding-left: 30px;
  padding-top: 10px;
}
.percent {
  font-size: 8pt;
  display: inline;
  margin: 0;
}
.percent + span {
  font-size: 6pt;
  font-weight: 100;
  color: #acacac;
}
.active {
  background-color: #ffdcdc;
}
.analysis:hover {
  cursor: pointer;
  background-color: #ffdcdc;
}
</style>