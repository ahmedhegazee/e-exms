import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);
import user from "./modules/user";
import student from "./modules/student";
import exam from "./modules/exam";
import professor from "./modules/professor";

const store = new Vuex.Store({
  modules: {
    user,
    student,
    exam,
    professor,
  },
});

export default store;
