import helpers from "@/services/helpers";
export default {
  namespaced: true,
  state: {
    exam: null,
    questions: [],
    answeredQuestions: [],
    skippedQuestions: [],
  },
  getters: {
    exam: (state) => state.exam,
    examQuestions: (state) => state.questions,
    skippedExamQuestions: (state) => state.skippedQuestions,
    answeredExamQuestions: (state) => state.answeredQuestions,
  },
  mutations: {
    SET_EXAM_AND_QUESTIONS(state, { questions, exam }) {
      state.questions = questions;
      state.exam = exam;
      localStorage.setItem("exam", JSON.stringify(state.exam));
      localStorage.setItem("questions", JSON.stringify(state.questions));
    },
    ADD_ANSWERED_QUESTION(state, question) {
      state.answeredQuestions = state.answeredQuestions.filter(function(q) {
        return question.id != q.id;
      });
      state.answeredQuestions.push(question);
      localStorage.setItem(
        "answeredQuestions",
        JSON.stringify(state.answeredQuestions)
      );
    },
    REMOVE_SKIPPED_QUESTION(state, question) {
      state.skippedQuestions = state.skippedQuestions.filter(function(q) {
        return question != q;
      });
    },
    CLEAR_EXAM(state) {
      state.skippedQuestions = [];
      state.exam = null;
      state.questions = [];
      state.answeredQuestions = [];
      localStorage.removeItem("exam");
      localStorage.removeItem("questions");
      localStorage.removeItem("answeredQuestions");
    },
  },
  actions: {},
};
