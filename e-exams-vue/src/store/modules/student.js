import StudentServices from "@/services/StudentServices";

export default {
  namespaced: true,
  state: {
    subjects: null,
    trainingExamResults: null,
    professors: null,
  },
  getters: {
    studentSubjects: (state) => {
      return state.subjects;
    },
    trainingExamResults: (state) => {
      return state.trainingExamResults;
    },
    professors: (state) => {
      return state.professors;
    },
  },
  mutations: {
    SET_SUBJECTS_DATA(state, subjectsData) {
      state.subjects = subjectsData;
      localStorage.setItem("subjects", JSON.stringify(subjectsData));
    },
    SET_TRAINING_EXAM_RESULTS_DATA(state, resultsData) {
      state.trainingExamResults = resultsData;
      localStorage.setItem("trainingExamResults", JSON.stringify(resultsData));
    },
    SET_PROFESSORS_DATA(state, professorsData) {
      state.professors = professorsData;
      localStorage.setItem("professorsData", JSON.stringify(professorsData));
    },
  },
  actions: {
    getSubjects({ commit }) {
      return StudentServices.getSubjects().then((response) =>
        commit("SET_SUBJECTS_DATA", response.data.data)
      );
    },
    getTrainingExamsResults({ commit }) {
      return StudentServices.getLastTrainingExams().then((response) =>
        commit("SET_TRAINING_EXAM_RESULTS_DATA", response.data.data)
      );
    },
    getProfessorsData({ commit }) {
      return StudentServices.getProfessors().then((response) => {
        commit("SET_PROFESSORS_DATA", response.data.data);
      });
    },
  },
};
