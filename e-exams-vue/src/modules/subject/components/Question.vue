<template>
  <div class="question row">
    <h2 class="row w-100">{{('Q'+(index+1)+')')+question.content}}</h2>
    <div class="row options w-100 justify-content-between">
      <span
        class="option"
        v-for="(option , index) in question.options"
        :key="index"
        :class="{'correct-answer':option.correct,'wrong-answer':question.wrong==index}"
      >{{options[index]+(option.content)}}</span>
      <span
        class="question-category"
        :class="{green:question.category==='A',yellow:question.category==='B',red:question.category==='C'}"
      ></span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    question: {
      required: true,
      type: Object
    },
    index: {
      required: true,
      type: Number
    }
  },
  data() {
    return {
      options: ["a.", "b.", "c.", "d."]
    };
  }
};
</script>

<style scoped>
.question {
  width: 100%;
  padding: 10px 40px;
  border-bottom: 1px solid #bbb;
}

.question h2 {
  font-size: 10pt;
  font-weight: 700;
  margin-bottom: 2%;
  margin-top: 1%;
}
.options {
  font-size: 8pt;
  font-weight: 300;
  margin-bottom: 1%;
}
.question-category {
  height: 10px;
  width: 10px;
  display: block;
  border-radius: 1px;
  margin-left: 20%;
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
.correct-answer {
  color: #1bd371;
}
.wrong-answer {
  color: #ff7271;
}
</style>