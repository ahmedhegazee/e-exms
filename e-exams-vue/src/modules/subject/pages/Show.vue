<template>
  <div>
    <div class="row">
      <img src alt />
      <h2>{{subject.name}}</h2>
      <h2 class="ml-2">Chapters</h2>
      <span class="total-questions">{{totalQuestions}}Q</span>
    </div>

    <div class="row pt-3 pb-5 pr-2 pl-2 items-container" v-if="currentChapter!=null">
      <div
        v-for="(chapter,index) in subject.chapters"
        :key="index"
        class="item chapter mr-3"
        @click="currentChapter=chapter"
        :class="{active:currentChapter.id==chapter.id}"
      >
        <h2 class="chapter-title d-inline">CH{{(index+1)}}</h2>
        <span style="margin-left: 25%">{{chapter.questions}}Q</span>
      </div>
    </div>
    <QuestionsContainer :chapter="currentChapter" v-if="currentChapter!=null" />
  </div>
</template>

<script>
import QuestionsContainer from "../components/QuestionsContainer";
export default {
  components: {
    QuestionsContainer
  },
  mounted() {
    this.currentChapter = this.subject.chapters[0];
  },
  props: {
    subject: {
      required: true,
      type: Object
    }
  },
  data() {
    return {
      currentChapter: null
    };
  },
  computed: {
    totalQuestions() {
      return this.subject.chapters
        .map(function(chapter) {
          return chapter.questions;
        })
        .reduce((total, num) => total + num);
    }
  }
};
</script>

<style scoped>
.active {
  color: #fff;
  background-color: #1bd371;
  text-decoration: none;
}
.chapters {
  height: 100px;
}
.chapter {
  padding: 15px 15px;
  flex: 0 0 12%;
  max-width: 12%;
}
.chapter-title {
  font-size: 16pt;
  font-weight: 600;
  margin: 0;
}
.chapter span {
  font-size: 9pt;
  font-weight: 300;
}
.total-questions {
  font-size: 9pt;
  font-weight: 300;
  color: #aaa;
  padding-top: 20px;
  padding-left: 10px;
}
</style>