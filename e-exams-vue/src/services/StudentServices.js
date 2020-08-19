import helpers from "./helpers";
export default {
  getSubjects() {
    return helpers.getInstance().get("subjects/students");
  },
  getLastTrainingExams() {
    return helpers.getInstance().get("training-exams/last-results");
  },
  getTrainingExamsResults(subject) {
    return helpers.getInstance().get(`subject/${subject}/training`);
  },
  getProfessors() {
    return helpers.getInstance().get("subjects/student/professors");
  }
};
