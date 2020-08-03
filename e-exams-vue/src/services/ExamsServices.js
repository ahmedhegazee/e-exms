import helpers from "./helpers";

export default {
  checkExamCode(code) {
    return helpers.getInstance().get(`exam/start?exam_code=${code}`);
  },
  submitExamAnswers(examId, answers) {
    return helpers.getInstance().post(`exam/${examId}/solve`, answers);
  },
};
