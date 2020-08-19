import helpers from "./helpers";
export default {
  getSubjects() {
    return helpers.getInstance().get("subjects/professors");
  },
  getRecentExams() {
    return helpers.getInstance().get("recent-exams");
  },
  getTopStudents() {
    return helpers.getInstance().get(`top-students`);
  },
  getLevels() {
    return helpers.getInstance().get("level");
  },
  getSubjectsByLevel(level) {
    return helpers.getInstance().get(`level/${level}/subjects`);
  },
  getResults(subject) {
    return helpers.getInstance().get(`subject/${subject}/analysis`);
  },
  addChapter(subject, chapter) {
    return helpers.getInstance().post(`subject/${subject}/chapter`, chapter);
  },
  updateChapter(subject, chapter) {
    return helpers
      .getInstance()
      .put(`subject/${subject}/chapter/${chapter.id}`, chapter);
  },
};
