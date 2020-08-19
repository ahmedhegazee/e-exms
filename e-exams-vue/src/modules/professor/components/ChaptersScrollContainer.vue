<template>
  <div>
    <div class="chapters-container pr-5 pl-3 pt-4">
      <div class="row justify-content-around">
        <chapter v-for="(chapter , index) in chapters" :key="index" :chapter="chapter" />
        <div class="col-3 mr-2 empty-chapter mb-5">
          <div class="row justify-content-center align-items-center" @click="addNewChapter">
            <i class="fas fa-plus"></i>
            <h5 class="mt-2">Add New Chapter</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import chapter from "./Chapter";
export default {
  props: {
    chapters: {
      required: true,
      type: Array,
      default: () => []
    }
  },
  components: {
    chapter
  },
  data() {
    return {};
  },
  methods: {
    addNewChapter() {
      this.$emit("openAddChapterDialogue");
    }
  }
};
</script>

<style scoped>
.chapters-container {
  overflow-y: scroll;
  height: 75vh;
}

.empty-chapter {
  background-color: transparent;
  border-radius: 10px;
  border: 3px solid #808183;
}
.empty-chapter .fa-plus {
  color: #808080;
  font-size: 50pt;
  width: 100%;
  margin-top: 30%;
}
.empty-chapter h5 {
  color: #acacac;
  font-size: 8pt;
}
</style>