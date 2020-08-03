<template>
  <div>
    <div class="row questions-container">
      <div class="row header">
        <h2 class="container-title mr-2">{{chapter.title}}</h2>
        <template v-if="wrongAnswers">
          <button
            class="mr-2 wrong-answers"
            :class="{'active-wrong-answers':type===1}"
            @click="type=1"
          >MCQ</button>
          <button
            class="mr-2 wrong-answers"
            :class="{'active-wrong-answers':type===2}"
            @click="type=2"
          >T-F</button>
        </template>
        <template v-else>
          <button class="mr-2" :class="{'active-button':type===1}" @click="type=1">MCQ</button>
          <button class="mr-2" :class="{'active-button':type===2}" @click="type=2">T-F</button>
        </template>
        <div class="d-inline select ml-4" v-if="!wrongAnswers">
          <select name id v-model="category">
            <option disabled value>Level</option>
            <option value="*">All</option>
            <option value="1">Easy</option>
            <option value="2">Moderate</option>
            <option value="3">Difficult</option>
          </select>
        </div>
      </div>
      <div class="row questions w-100" @scroll="onScroll">
        <Question
          :question="question"
          :index="index"
          v-for="(question, index) in questions"
          :key="index"
        />
        <div v-if="questions.length==0">No questions available</div>
      </div>
    </div>
  </div>
</template>

<script>
import Question from "./Question";
import SubjectServices from "../../../services/SubjectServices";
export default {
  components: {
    Question
  },
  props: {
    chapter: {
      required: true,
      type: Object
    },
    wrongAnswers: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    this.getQuestions();
  },
  watch: {
    chapter(newValue, oldValue) {
      this.type = 1;
      this.category = "";
      this.questions = [];
      this.currentPage = 1;
      this.getQuestions();
    },
    type(newType, oldType) {
      this.getQuestions();
      this.currentPage = 1;
    },
    category(newCategory, oldCategory) {
      if (newCategory == "*") this.category = "";
      this.getQuestions();
      this.currentPage = 1;
    }
  },
  methods: {
    getQuestions() {
      if (this.wrongAnswers) {
        SubjectServices.getWrongAnswersBySubject(
          this.chapter.id,
          this.type
        ).then(response => {
          if (response.data.answers) {
            this.questions = response.data.answers;
            this.lastPage = response.data.pages_count;
          } else {
            this.questions = [];
          }
        });
      } else {
        SubjectServices.getChapterQuestions(
          this.$route.params.id,
          this.chapter.id,
          this.type,
          this.category
        ).then(response => {
          this.questions = response.data.data;
          this.lastPage = response.data.meta.last_page;
        });
      }
    },
    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        this.currentPage++;
        if (this.currentPage <= this.lastPage) {
          if (this.wrongAnswers) {
            SubjectServices.getWrongAnswersBySubject(
              this.chapter.id,
              this.type,
              this.currentPage
            ).then(response => {
              if (response.data.answers) {
                this.questions = this.questions.concat(response.data.answers);
              } else {
                this.questions = [];
              }
            });
          } else {
            SubjectServices.getChapterQuestions(
              this.$route.params.id,
              this.chapter.id,
              this.type,
              this.category,
              this.currentPage
            ).then(response => {
              this.questions = this.questions.concat(response.data.data);
            });
          }
        }
      }
    }
  },

  data() {
    return {
      questions: [],
      type: 1,
      category: "",
      currentPage: 1,
      lastPage: 1
    };
  }
};
</script>

<style scoped>
.questions {
  overflow-y: scroll;
  height: 60vh;
}
.questions-container {
  background-color: #fff;
  color: #000;
  padding: 30px 50px;
  width: 98%;
  border-radius: 10px;
}
.header {
  width: 100%;
}
button {
  background-color: transparent;
  color: #21cf6b;
  border-color: #c7ffda !important;
  border-radius: 5px;
  padding: 2px 30px;
  font-size: 8pt;
}
.active-button,
button:hover {
  background-color: #c7ffda;
}
select {
  word-wrap: normal;
  background-color: transparent;
  border: 0;
  font-size: 10pt;
  width: 10vw;
}
.select {
  border-bottom: 1px solid #ccc;
}
.wrong-answers:hover,
.active-wrong-answers {
  background-color: #ffdcdc;
}
.wrong-answers {
  color: #ff7171;
  border-color: #ffdcdc !important;
}
</style>


