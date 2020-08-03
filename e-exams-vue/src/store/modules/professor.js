import ProfessorServices from "@/services/ProfessorServices";

export default {
  namespaced: true,
  state: {
    subjects: null,
    recentExams: null,
    topStudents: null,
  },
  getters: {
    professorSubjects: (state) => {
      return state.subjects;
    },
    recentExams: (state) => {
      return state.recentExams;
    },
    topStudents: (state) => {
      return state.topStudents;
    },
  },
  mutations: {
    SET_SUBJECTS_DATA(state, subjectsData) {
      state.subjects = subjectsData;
      localStorage.setItem("subjects", JSON.stringify(subjectsData));
    },
    SET_RECENT_EXAMS(state, examsData) {
      state.recentExams = examsData;
      localStorage.setItem("recentExams", JSON.stringify(examsData));
    },
    SET_TOP_STUDENTS(state, studentsData) {
      state.topStudents = studentsData;
      localStorage.setItem("topStudents", JSON.stringify(studentsData));
    },
  },
  actions: {
    getSubjects({ commit }) {
      return ProfessorServices.getSubjects().then((response) =>
        commit("SET_SUBJECTS_DATA", response.data.data)
      );
    },
    getRecentExams({ commit }) {
      return ProfessorServices.getRecentExams().then((response) =>
        commit("SET_RECENT_EXAMS", response.data)
      );
    },
    getTopStudents({ commit }) {
      return ProfessorServices.getTopStudents().then((response) =>
        commit("SET_TOP_STUDENTS", response.data)
      );
    },
  },
};
