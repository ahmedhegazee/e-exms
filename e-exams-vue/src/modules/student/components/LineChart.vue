<script>
import { Line, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;
export default {
  extends: Line,
  mixins: [reactiveProp],
  props: ["chartData", "options", "height"],
  mounted() {
    this.renderChart(this.chartData, this.options);
  },
  watch: {
    chartData: function() {
      this.renderChart(this.chartData, this.options);
    }
  }
};
</script>

<style>
</style>