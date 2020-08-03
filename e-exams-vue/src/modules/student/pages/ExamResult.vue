<template>
  <div>
    <div class="navbar row justify-content-between" v-if="userData!=null">
      <div>
        <img src alt />
      </div>
      <span>Official Exam</span>
      <div>
        <span id="fullname" style="color:#000">{{userData.full_name}}</span>
        <BaseImage :source="userData.thumbnail_image" alt width="30px" class="ml-2" />
      </div>
    </div>
    <div class="content row justify-content-center mt-4">
      <h1 class="w-100 mb-4">{{result.subject}}</h1>
      <div class="result" :class="{green:result.result.percent>=50,red:result.result.percent<50}">
        <p class="mb-2">the score</p>
        <h1>{{result.result.score}}</h1>
        <p>from {{result.result.total_questions}}</p>
        <p class="percent">{{percent}}</p>
      </div>
    </div>
    <div class="content row questions mt-4 justify-content-between">
      <div class="col-md-4">
        <h3>MCQ</h3>
        <span class="question-category green mr-2"></span>
        <p>
          {{result.mcq.true}}
          <span class="correct">right</span>
          from {{result.mcq.total}}
        </p>
        <br />
        <span class="question-category red mr-2"></span>
        <p>
          {{result.mcq.false}}
          <span class="wrong">wrong</span>
          from {{result.mcq.total}}
        </p>
      </div>
      <div class="col-md-4">
        <h3>T-F</h3>
        <span class="question-category green mr-2"></span>
        <p>
          {{result.true_false.true}}
          <span class="correct">right</span>
          from {{result.true_false.total}}
        </p>
        <br />
        <span class="question-category red mr-2"></span>
        <p>
          {{result.true_false.false}}
          <span class="wrong">wrong</span>
          from {{result.true_false.total}}
        </p>
      </div>
      <div class="col-md-4 mr-2"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    result: {
      type: Object,
      required: true
    }
  },
  computed: {
    ...mapGetters("user", ["userData"]),
    percent() {
      let percent = Math.round(this.result.result.percent);
      return percent >= 50 ? percent + "% Successful" : percent + "% Failed";
    }
  }
};
</script>

<style scoped>
.navbar {
  height: 13vh;
  padding: 0 60px;
  background-color: #f6f7fb;
  color: #1bd371;
}
.content {
  /* height: 87vh; */
  /* padding-top: 2%; */
  width: 50%;
  margin: 0 auto;
  font-size: 20pt;
}
h1 {
  font-size: 28pt;
  text-align: center;
}
p {
  text-align: center;
  margin: 0;
  line-height: 1.4;
}
.result {
  width: 100%;
  padding: 60px 20px;
  border-radius: 20px;
  color: #fff;
}
.result h1 {
  font-size: 62pt;
  line-height: 0.7;
  margin: 0;
}
.percent {
  text-align: center;
  width: 60%;
  margin: 0 auto;
  border-top: 1px solid #fff;
  border-bottom: 1px solid #fff;
  padding: 5px 0;
  font-size: 20pt;
}
.content:last-of-type {
  padding: 0 25px;
}
.red {
  background-color: #ff7271;
}
.green {
  background-color: #1bd371;
}
.wrong {
  color: #ff7271;
}
.correct {
  color: #1bd371;
}

.question-category {
  height: 10px;
  width: 10px;
  border-radius: 1px;
  display: inline-block;
}
.questions {
  font-family: NexaLight;
}
.questions h3 {
  font-size: 16pt;
  text-align: center;
}
.questions p {
  display: inline-block;
  font-size: 14pt;
}
</style>