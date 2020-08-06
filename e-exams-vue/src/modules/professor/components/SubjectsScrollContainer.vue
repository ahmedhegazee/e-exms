<template>
  <div>
    <div class="subjects-container">
      <div
        class="subject mb-3"
        v-for="(subject , index) in subjects"
        :key="index"
        :class="{active:currentSubject.id==subject.id}"
        @click="changeCurrentSubject(subject)"
      >
        <h5 class="d-inline mr-3">{{subject.name}}</h5>
        <span>{{subject.code}}</span>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    subjects: {
      required: true,
      type: Array,
      default: () => []
    }
  },
  computed: {
    ...mapGetters("professor", ["currentSubject"])
  },
  // data() {
  //   return {
  //     currentSubject: 1
  //   };
  // },
  methods: {
    changeCurrentSubject(subject) {
      this.$store.commit("professor/SET_CURRENT_SUBJECT", subject);
      // this.currentSubject = subject;
      // this.$emit("subjectChanged", subject);
    }
  }
};
</script>

<style scoped>
.subjects-container {
  overflow-y: scroll;
  height: 75vh;
  padding-top: 20px;
}

.subject {
  background-color: #fff;
  color: #acacac;
  padding: 8px 15px;
  box-shadow: 1px 2px 3px 0px rgb(0 0 0 / 20%);
  border-radius: 10px;
}
.subject h5 {
  font-size: 1rem;
  font-weight: 100;
}
.subject span {
  font-size: 0.5rem;
}
.subject:hover,
.active {
  background-color: #1bd371 !important;
  color: #fff;
  cursor: pointer;
}
</style>