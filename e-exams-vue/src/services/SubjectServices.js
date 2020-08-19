import helpers from "./helpers";

export default {
  getSubjectChapters(subjectID) {
    return helpers.getInstance().get(`subject/${subjectID}/chapter`);
  },
  getChapterQuestions(subjectID, chapterID, type, category = "", page = 1) {
    let params =
      category.length == 0
        ? `type=${type}`
        : `type=${type}&category=${category}`;
    return helpers
      .getInstance()
      .get(
        `subject/${subjectID}/chapter/${chapterID}/question?${params}&page=${page}`
      );
  },
  getWrongAnswersBySubject(subject, type, page = 1) {
    return helpers
      .getInstance()
      .get(`subject/${subject}/wrong-answers?page=${page}&type=${type}`);
  }
};
