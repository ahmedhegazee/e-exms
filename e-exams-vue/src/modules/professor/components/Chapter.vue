<template>
  <div class="col-3 mr-2 chapter mb-5">
    <div id="header" class="mb-2 mt-2">
      <h5 class="d-inline mr-3">{{chapter.name}}</h5>
      <span>{{chapter.num}}</span>
    </div>
    <div id="content">
      <div class="mb-1 method">
        <i class="fas fa-plus"></i>
        <span class="ml-2">Add Question</span>
      </div>
      <div class="mb-1 method">
        <i class="fas fa-dollar-sign"></i>
        <span class="ml-2">Question Bank</span>
      </div>
      <div class="mb-1 method">
        <i class="fas fa-pen"></i>
        <span class="ml-2" @click="editChapter">Edit</span>
      </div>
      <div class="mb-1 method">
        <i class="fas fa-trash-alt"></i>
        <span class="ml-2">Delete</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    chapter: {
      required: true,
      type: Object
    }
  },
  methods: {
    editChapter() {
      this.$store.commit("professor/SET_CURRENT_CHAPTER", this.chapter);
    }
  }
};
</script>

<style scoped>
.chapter {
  background-color: #fff;

  padding: 8px 15px;
  box-shadow: 1px 2px 3px 0px rgb(0 0 0 / 20%);
  border-radius: 10px;
}
.chapter h5 {
  font-size: 1rem;
  font-weight: 100;
}
.chapter span {
  font-size: 0.5rem;
  color: #acacac;
}
.fa-plus,
.fa-dollar-sign {
  color: #1bd371;
}
.fa-pen {
  color: #ffe96f;
}
.fa-trash-alt {
  color: #ff7271;
}
.fa-plus,
.fa-dollar-sign,
.fa-pen,
.fa-trash-alt {
  font-size: 8pt;
}
.method :hover {
  cursor: pointer;
}
</style>