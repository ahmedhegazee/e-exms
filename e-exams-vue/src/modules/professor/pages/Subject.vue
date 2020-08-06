<template>
  <div>
    <div class="row">
      <i class="fas fa-file-signature"></i>
      <h5 class="d-inline ml-2" style="line-height: 1.9;">Subjects</h5>
    </div>
    <div class="row">
      <div class="col-4">
        <SubjectsContainer :subjects="professorSubjects" v-if="professorSubjects" />
      </div>
      <div class="col-8">
        <template v-if="currentSubject">{{currentSubject.name}} chapters</template>
        <ChaptersContainer
          :chapters="currentSubject.chapters"
          @openAddChapterDialogue="showDialogue=true"
          v-if="currentSubject"
        />
      </div>
    </div>
    <AddNewChapter
      v-if="showDialogue"
      @closeDialogue="showDialogue=false"
      @newChapter="addChapter"
    />
    <EditChapter v-if="currentChapter" :chapter="currentChapter" />
  </div>
</template>

<script>
import SubjectsContainer from "../components/SubjectsScrollContainer";
import ChaptersContainer from "../components/ChaptersScrollContainer";
import AddNewChapter from "../components/AddNewChapter";
import EditChapter from "../components/EditChapter";
import { mapGetters } from "vuex";
export default {
  components: {
    SubjectsContainer,
    ChaptersContainer,
    AddNewChapter,
    EditChapter
  },
  mounted() {
    this.$store.commit(
      "professor/SET_CURRENT_SUBJECT",
      this.professorSubjects[0]
    );
  },
  computed: {
    ...mapGetters("professor", [
      "professorSubjects",
      "currentSubject",
      "currentChapter"
    ])
  },
  data() {
    return {
      // currentSubject: {},
      showDialogue: false
    };
  },
  methods: {
    addChapter(chapter) {
      this.$store.dispatch("professor/addNewChapter", chapter);
    }
  }
};
</script>

<style scoped>
.fa-file-signature {
  font-size: 30pt;
  color: #1bd371;
}
</style>