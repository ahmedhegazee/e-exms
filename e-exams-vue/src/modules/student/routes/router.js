import Analytics from "../pages/Analytics";
import Exam from "../pages/Exam";
import SolveExam from "../pages/SolveExam";
import ExamResult from "../pages/ExamResult";
import store from "../../../store/store";
export default [
  {
    path: "/analytics",
    name: "analytics",
    component: Analytics,
    meta: {
      requiresAuth: true,
      layout: "layout",
    },
  },
  {
    path: "/exam",
    name: "exam",
    component: Exam,
    meta: {
      isExam: true,
      requiresAuth: true,
      layout: "",
    },
  },
  {
    path: "/exam/solve",
    name: "solve-exam",
    component: SolveExam,
    meta: {
      isExam: true,
      requiresAuth: true,
      layout: "",
    },
    beforeEnter: (to, from, next) => {
      if (!store.exam) next({ name: "exam" });
      next();
    },
  },
  {
    path: "/exam/result",
    name: "exam-result",
    component: ExamResult,
    props: true,
    meta: {
      isExam: true,
      requiresAuth: true,
      layout: "",
    },
    beforeEnter: (to, from, next) => {
      if (!from.params.result) next({ name: "exam" });
      next();
    },
  },
];
