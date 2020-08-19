<template>
  <div class="scores-container shadow bg-white p-2">
    <div class="row justify-content-end">
      <div class="subject-select">
        <select id v-model="level">
          <option value disabled>Student Level</option>
          <option v-for="(leve, index) in levels" :key="index" :value="leve.id">{{leve.name}}</option>
        </select>
      </div>
      <div class="subject-select mr-4">
        <select id v-model="subject">
          <option value disabled>Subject</option>
          <option
            v-for="(subject, index) in subjects"
            :key="index"
            :value="subject.id"
          >{{subject.name}}</option>
        </select>
      </div>
    </div>
    <LineChart :chart-data="chartData" :options="options" :height="300" />
  </div>
</template>

<script>
import LineChart from "./LineChart";
import ProfessorServices from "@/services/ProfessorServices";
export default {
  mounted() {
    ProfessorServices.getLevels().then(
      response => (this.levels = response.data.data)
    );
  },
  components: {
    LineChart
  },
  watch: {
    level(newLevel, oldLevel) {
      ProfessorServices.getSubjectsByLevel(newLevel).then(
        response => (this.subjects = response.data.data)
      );
    },
    subject(newSubject, oldSubject) {
      ProfessorServices.getResults(newSubject).then(response => {
        this.createChartData(response.data);
        // this.chartData.labels =
        // response.data.results.map(function(result) {
        //   return result.date;
        // });
        // this.chartData.datasets.data =
        // response.data.results.map(function(
        //   result
        // ) {
        //   return result.score;
        // });
      });
    }
  },

  data() {
    return {
      levels: [],
      subjects: [],
      level: "",
      subject: "",
      chartData: {
        labels: [],
        datasets: [
          {
            // one line graph
            label: "Succeeded Students",
            data: [],
            backgroundColor: ["rgba(0, 0, 0, 0)"],
            borderColor: ["#1bd371"],
            borderWidth: 3
          },
          {
            // one line graph
            label: "Failed Students",
            data: [],
            backgroundColor: ["rgba(0, 0, 0, 0)"],
            borderColor: ["#ff7271"],
            borderWidth: 3
          }
        ]
      },
      options: {
        responsive: true,
        lineTension: 1,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
                padding: 25
              }
            }
          ]
        }
      }
    };
  },
  methods: {
    createChartData(data) {
      const labels = data.map(function(result) {
        return result.exam_time;
      });
      const succeededStudents = data.map(function(result) {
        return result.succeeded_students;
      });
      const failedStudents = data.map(function(result) {
        return result.failed_students;
      });
      this.chartData = {
        labels: labels,
        datasets: [
          {
            label: "Succeeded Students",
            data: succeededStudents,
            backgroundColor: ["rgba(27, 211, 113, 1)"],
            borderColor: ["#1bd371"],
            borderWidth: 3
          },
          {
            label: "Failed Students",
            data: failedStudents,
            backgroundColor: ["rgba(255, 114, 113, 1)"],
            borderColor: ["#ff7271"],
            borderWidth: 3
          }
        ]
      };
    }
  }
};
</script>

<style>
.small {
  max-width: 600px;
  margin: 150px auto;
}
.scores-container {
  border-radius: 15px;
}
.subject-select {
  background-color: #eaeaea;
  border-radius: 25px;
  padding: 4px 20px;
  display: inline-block;
  margin: 0 5px;
}
select {
  background-color: transparent;
  border: 0;
  font-size: 6pt;
  width: 100%;
}
</style>