import Vue from "vue";
import VueRouter from "vue-router";
import NProgress from "nprogress";
import store from "../store/store";
import mainRoutes from "./mainRoutes";
import subjectRoutes from "../modules/subject/routes/router";
import studentRoutes from "../modules/student/routes/router";
import professorRoutes from "../modules/professor/router";
import auth from "./authRoutes";
import errors from "./errorRoutes";
Vue.use(VueRouter);
const baseRoutes = auth.concat(errors);
let routes = baseRoutes
  .concat(mainRoutes)
  .concat(subjectRoutes)
  .concat(studentRoutes)
  .concat(professorRoutes);
const router = new VueRouter({
  base: "/",
  mode: "history",
  routes,
});

router.beforeEach((routeTo, routeFrom, next) => {
  NProgress.start();
  const loggedin = localStorage.getItem("user");
  // if user goes to auth routes redirect him to the dashboard page
  if (routeTo.matched.some((record) => record.meta.auth) && loggedin) {
    next({ name: "dashboard" });
  }
  // if user is not loggedin , redirect him to the login page
  if (routeTo.matched.some((record) => record.meta.requiresAuth) && !loggedin) {
    next({ name: "login" });
  }
  setTimeout(() => {
    next();
  }, 4000);
});
router.afterEach(() => {
  NProgress.done();
});
export default router;
