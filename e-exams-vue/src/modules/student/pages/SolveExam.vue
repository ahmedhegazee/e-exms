<template>
  <div>
    <div class="aside green" @click="openSkipped=!openSkipped">Skipped Questions</div>
    <div class="skipped-questions" v-if="openSkipped">
      <div class="row">
        <div class="bg-white col-3 content" style="height:100vh">
          <h1>Enter number of question you want to go</h1>
          <input
            type="text"
            class="mb-2"
            v-model.number="skippedQuestion"
            placeholder="Enter question number"
            :class="{ error: $v.skippedQuestion.$error }"
          />
          <template v-if="$v.skippedQuestion.$error">
            <p
              class="error-message p-1"
              v-if="!$v.skippedQuestion.required"
            >Question Number is required</p>
            <p
              class="error-message p-1"
              v-if="!$v.skippedQuestion.isCurrent&&$v.skippedQuestion.required"
            >Write correct question number</p>
          </template>
          <button class="mb-4" @click="getSkippQuestionByIndex">Go</button>
          <div class="sk-q">
            <h1>The Skipped Questions</h1>
            <div
              class="question"
              v-for="(question,index) in skippedExamQuestions"
              :key="index"
              @click="getSkippedQuestion(question)"
            >Q{{question.index+1}}</div>
            <!-- <div class="question">Q13</div>
            <div class="question">Q15</div>-->
          </div>
        </div>
        <div class="col-2">
          <div class="skipped-aside" @click="openSkipped=!openSkipped">Skipped Questions</div>
        </div>
      </div>
    </div>
    <div class="navbar row justify-content-between">
      <div>
        <img src alt />
        <span>{{exam.subject_title}}</span>
      </div>
      <span>Official Exam</span>
      <div>
        <span id="fullname" style="color:#000">{{userData.full_name}}</span>
        <BaseImage :source="userData.thumbnail_image" alt width="30px" class="ml-2" />
      </div>
    </div>

    <div class="content">
      <div class="timer">{{time}}</div>
      <div class="questions-container">
        <div class="question" v-if="currentQuestion!=null">
          <h1 class="mb-4">Q {{index+1}}</h1>
          <p class="mb-4">{{currentQuestion.question_content}}</p>
          <div class="options">
            <span v-for="(option,index) in currentQuestion.options" :key="index">
              <input
                type="radio"
                name="option"
                v-model="optionAnswer"
                :value="option.index"
                :id="'o'+index"
              />
              <label :for="'o'+index">{{option.content}}</label>
            </span>
            <!-- <input type="radio" name="option" v-model="optionAnswer" value="option 1" id="o2" />
            <label for="o2">option 2</label>
            <input type="radio" name="option" v-model="optionAnswer" value="option 3" id="o3" />
            <label for="o3">option 3</label>
            <input type="radio" name="option" v-model="optionAnswer" value="option 4" id="o4" />
            <label for="o4">option 4</label>-->
          </div>
          <div class="row justify-content-between buttons">
            <button class="btn red" @click="getPreviousQuestion">Back</button>
            <button
              class="btn green"
              @click="skipQuestion"
              v-if="!isFinished&&optionAnswer==null"
            >Skip</button>
            <button
              class="btn green"
              @click="getNextQuestion"
              v-if="!isFinished&&optionAnswer!=null"
            >Next</button>
            <button class="btn green" @click="showExitDialog=true" v-if="isFinished">Finish</button>
          </div>
        </div>
      </div>
    </div>
    <div class="skipped-questions" style="z-index:1" v-if="showExitDialog">
      <div class="row justify-content-center">
        <div class="exit-dialog bg-white">
          <h1 class="mb-4">Are you sure to finish the exam</h1>
          <button class="mb-4" @click="submitAnswers">Yes</button>
          <button @click="showExitDialog=false">No</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import ExamsServices from "../../../services/ExamsServices";
import { mapGetters } from "vuex";
export default {
  created() {
    // window.addEventListener("beforeunload", function(event) {
    //   // event.preventDefault();
    //   this.showExitDialog = true;
    //   prompt("You are closing page");
    //   event.returnValue = "You are closing the page";
    //   event.bubbles = false;
    //   return null;
    // });
  },
  mounted() {
    this.getCurrentQuestion();
    let timer = this.exam.time.split(":");
    let minutes = parseInt(timer[1]);
    let hours = parseInt(timer[0]);
    let seconds = 0;
    var countDownDate = new Date();
    countDownDate.setMinutes(countDownDate.getMinutes() + minutes);
    countDownDate.setHours(countDownDate.getHours() + hours);
    let self = this;
    // Update the count down every 1 second
    let counter = setInterval(function() {
      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element with id="demo"
      self.time = `${hours} : ${minutes} : ${seconds}`;

      // If the count down is over, write some text
      if (distance < 0) {
        clearInterval(counter);
        // document.getElementById("timer").innerHTML = "EXPIRED";
        // $('#submit').click();
        // console.log("timer ended");
        self.submitAnswers();
      }
    }, 1000);
  },
  computed: {
    ...mapGetters("user", ["userData"]),
    ...mapGetters("exam", [
      "exam",
      "examQuestions",
      "skippedExamQuestions",
      "answeredExamQuestions"
    ]),
    isFinished() {
      return this.index == this.examQuestions.length - 1;
    }
  },
  data() {
    return {
      openSkipped: false,
      optionAnswer: null,
      showExitDialog: false,
      currentQuestion: null,
      index: 0,
      skippedQuestion: "",
      timer: null,
      time: ""
    };
  },
  validations: {
    skippedQuestion: {
      required,
      isCorrect(question) {
        if (question == "") return true;
        for (let i = 0; i < this.skippedExamQuestions.length; i++) {
          if (this.skippedExamQuestions[i].index + 1 == question) return true;
        }
        return false;
      }
    }
  },
  methods: {
    getCurrentQuestion() {
      this.currentQuestion = this.examQuestions[this.index];
      this.optionAnswer =
        this.currentQuestion.answer != undefined
          ? this.currentQuestion.answer
          : null;
    },
    getPreviousQuestion() {
      if (this.index > 0) {
        this.index--;
      }
      this.getCurrentQuestion();
      this.isSkippedQuestion();
    },
    isSkippedQuestion() {
      if (this.skippedExamQuestions.indexOf(this.currentQuestion) != -1)
        this.$store.commit(
          "exam/REMOVE_SKIPPED_QUESTION",
          this.currentQuestion
        );
    },
    skipQuestion() {
      if (this.index < this.examQuestions.length - 1) {
        this.currentQuestion.index = this.index;
        this.index++;
        if (this.skippedExamQuestions.indexOf(this.currentQuestion) == -1)
          this.skippedExamQuestions.push(this.currentQuestion);
        this.getCurrentQuestion();
      }
    },
    getNextQuestion() {
      this.currentQuestion.answer = this.optionAnswer;
      this.$store.commit("exam/ADD_ANSWERED_QUESTION", this.currentQuestion);
      // this.answeredExamQuestions.push(this.currentQuestion);
      this.isSkippedQuestion();
      if (this.examQuestions.length - 1 > this.index) this.index++;
      this.getCurrentQuestion();
    },
    getSkippedQuestion(question) {
      this.skipQuestion();
      this.index = question.index;
      this.$store.commit("exam/REMOVE_SKIPPED_QUESTION", question);
      this.getCurrentQuestion();
      this.openSkipped = false;
    },
    getSkippQuestionByIndex() {
      this.$v.$touch();
      if (this.$v.$invalid) return;
      let question = null;
      for (let i = 0; i < this.skippedExamQuestions.length; i++) {
        if (this.skippedExamQuestions[i].index == this.skippedQuestion - 1)
          question = this.skippedExamQuestions[i];
      }
      this.getSkippedQuestion(question);
      this.skippedQuestion = "";
    },
    submitAnswers() {
      let answers = [];
      let questions = this.examQuestions;
      for (let i = 0; i < questions.length; i++) {
        let question = questions[i];
        answers.push({
          question: question.id,
          answer: question.answer != undefined ? question.answer : -1
        });
      }
      ExamsServices.submitExamAnswers(this.exam.id, {
        answers
      }).then(response => {
        let result = response.data;
        result.subject = this.exam.subject_title;
        this.$store.commit("exam/CLEAR_EXAM");
        this.$router.push({ name: "exam-result", params: { result } });
      });
    }
  }
};
</script>

<style scoped>
.navbar {
  height: 13vh;
  padding: 0 60px;
  background-color: #f6f7fb;
  z-index: 1;
  color: #1bd371;
}
.content {
  height: 87vh;
  padding-top: 2%;
}
.timer {
  font-size: 14pt;
  text-align: center;
}
.questions-container {
  padding-top: 5%;
  padding-left: 20%;
}
.question {
  width: 80%;
}
h1 {
  font-size: 14pt;
}
p,
input[type="radio"],
label,
.btn {
  font-size: 10pt;
  font-family: NexaLight;
}
input[type="radio"] {
  width: 20px;
  height: 20px;
}
label {
  display: inline;
  display: inline;
  position: relative;
  left: 20px;
  font-size: 14pt;
  top: -5px;
}
label::after {
  content: "";
  display: block;
  margin-bottom: 2%;
}
.btn {
  color: #fff;
  border: 0;
  border-radius: 50%;
  width: 50px;
  height: 50px;
}
.red {
  background-color: #ff7271;
}
.green {
  background-color: #1bd371;
}
.buttons {
  margin-top: 10%;
}
.aside,
.skipped-aside {
  position: absolute;
  transform: rotate(90deg);
  font-size: 12pt;
  -webkit-clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%);
  clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%);
}
.aside:hover,
.skipped-aside:hover {
  cursor: pointer;
}
.aside {
  top: 30vh;
  left: -8%;
  padding: 20px 40px;
  color: #fff;
}
.skipped-aside {
  z-index: 1;
  top: 41vh;
  left: -50%;
  background-color: #fff;
  padding: 20px 60px;
  color: #1bd371;
}
.skipped-questions {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.3);
}
.skipped-questions .content {
  padding-top: 20vh;
  z-index: 1;
  padding-left: 4%;
}

.skipped-questions .content h1 {
  font-size: 12pt;
}
.skipped-questions .content input {
  border: 1px solid #ccc;
}
.skipped-questions .content input::placeholder {
  font-size: 8pt;
  font-family: NexaLight;
  padding: 5px 10px;
}
.skipped-questions .content button {
  border: 0;
  background-color: #1bd371;
  color: #fff;
  padding: 5px;
}
.skipped-questions .content input,
.skipped-questions .content button {
  width: 100%;
  border-radius: 10px;
}
.sk-q {
  border-top: 1px solid #ddd;
  padding-top: 15px;
}
.sk-q h1 {
  font-size: 10pt;
}
.sk-q .question {
  border-bottom: 1px solid #ddd;
  padding: 15px 0;
  font-size: 10pt;
  font-family: NexaLight;
}
.exit-dialog {
  margin-top: 30vh;
  width: 35%;
  height: 45vh;
  padding: 70px 100px;
  border-radius: 10px;
}
.exit-dialog h1 {
  font-size: 34px;
  color: #ff7271;
}
.exit-dialog button {
  width: 100%;
  border: 1px solid #ff7271;
  padding: 5px;
  background-color: transparent;
  color: #ff7271;
}
.exit-dialog button:nth-of-type(2),
.exit-dialog button:hover {
  background-color: #ff7271;
  color: #fff;
}
</style>