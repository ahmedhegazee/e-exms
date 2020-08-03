<template>
  <div class="scores-container shadow bg-white p-2">
    <div class="row justify-content-end mr-3 mt-3">
      <div class="subject-select">
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
import StudentServices from "@/services/StudentServices";
export default {
  components: {
    LineChart
  },
  watch: {
    subject(newSubject, oldSubject) {
      StudentServices.getTrainingExamsResults(newSubject).then(response => {
        this.createChartData(response.data.results);
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
  computed: {
    subjects() {
      return this.$store.getters["student/studentSubjects"];
    }
  },
  data() {
    return {
      subject: "",
      // subjects: [
      //   { id: 1, name: "Subject 1" },
      //   { id: 2, name: "Subject 2" },
      //   { id: 3, name: "Subject 3" },
      //   { id: 4, name: "Subject 4" },
      //   { id: 5, name: "Subject 5" }
      // ],
      chartData: {
        labels: [
          // "Mercury",
          // "Venus",
          // "Earth",
          // "Mars",
          // "Jupiter",
          // "Saturn",
          // "Uranus",
          // "Neptune"
        ],
        datasets: [
          {
            // one line graph
            label: "Training Exam Results",
            // data: [0, 0, 1, 2, 67, 62, 27, 14],
            data: [],
            backgroundColor: [
              // "rgba(54,73,93,.5)", // Blue
              // "rgba(54,73,93,.5)",
              // "rgba(54,73,93,.5)",
              // "rgba(54,73,93,.5)",
              // "rgba(54,73,93,.5)",
              // "rgba(54,73,93,.5)",
              // "rgba(54,73,93,.5)",
              // "rgba(54,73,93,.5)"
              "rgba(0, 0, 0, 0)"
            ],
            borderColor: [
              // "#36495d",
              // "#36495d",
              // "#36495d",
              // "#36495d",
              // "#36495d",
              // "#36495d",
              // "#36495d",
              // "#36495d"
              "#1bd371"
            ],
            borderWidth: 3
          }
          // {
          //   // another line graph
          //   label: "Planet Mass (x1,000 km)",
          //   data: [4.8, 12.1, 12.7, 6.7, 139.8, 116.4, 50.7, 49.2],
          //   // backgroundColor: [
          //   //   "rgba(71, 183,132,.5)" // Green
          //   // ],
          //   borderColor: ["#47b784"],
          //   borderWidth: 3
          // }
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
        return result.date;
      });
      const datasets = data.map(function(result) {
        return result.score;
      });
      this.chartData = {
        labels: labels,
        datasets: [
          {
            // one line graph
            label: "Training Exam Results",
            data: datasets,
            backgroundColor: ["rgba(0, 0, 0, 0)"],
            borderColor: ["#1bd371"],
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
}
select {
  background-color: transparent;
  border: 0;
  width: 100%;
  font-size: 8pt;
}
</style>