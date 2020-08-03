import helpers from "@/services/helpers";
import StudentServices from "@/services/StudentServices";

export default {
  namespaced: true,
  state: {
    subject: null,
    questions: null
  },
  getters: {
    subject: state => {
      return state.subject;
    },
    questions: state => {
      return state.questions;
    }
  },
  mutations: {
    SET_SUBJECT_DATA(state, subjectData) {
      state.subject = subjectData;
      // localStorage.setItem("subjects", JSON.stringify(subjectsData));
    },
    SET_QUESTIONS_DATA(state, questionsData) {
      state.questions = questionsData;
      // localStorage.setItem("trainingExamResults", JSON.stringify(resultsData));
    }
  },
  actions: {
    getChapters({ commit }) {
      return StudentServices.getSubjects().then(response =>
        commit("SET_SUBJECT_DATA", response.data.data)
      );
    },
    getQuestions({ commit }) {
      return StudentServices.getLastTrainingExams().then(response =>
        commit("SET_QUESTIONS_DATA", response.data.data)
      );
    }
  }
};
