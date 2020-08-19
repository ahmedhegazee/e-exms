import Subject from "./pages/Subject";
import store from "../../store/store";
export default [
  {
    name: "professor-subject",
    component: Subject,
    path: "/subject",
    meta: {
      requiresAuth: true,
      layout: "layout",
    },
    beforeEnter: (to, from, next) => {
      store
        .dispatch("professor/getSubjects")
        .then(() => next())
        .catch(() => next({ name: "network-issue" }));
      // next();
    },
  },
];
