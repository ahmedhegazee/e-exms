import DashBoard from "../pages/DashBoard";
import Profile from "../pages/Profile";
import NProgress from "nprogress";
import store from "../store/store";

export default [
  {
    name: "dashboard",
    path: "/dashboard",
    component: DashBoard,
    meta: {
      requiresAuth: true,
      layout: "layout",
    },
    // beforeEnter: (to, from, next) => {
    //   //to let data be loaded from localstorage
    //   if (store.user == null) {
    //     NProgress.start();
    //     setTimeout(function() {
    //       NProgress.done();
    //       next();
    //     }, 2000);
    //   } else next();
    // },
    // beforeEnter(to, from, next) {
    //   NProgress.start();
    //   console.log(store.getters["user/isStudent"]);
    //   let loadedData = 0;
    //   if (store.getters["user/isStudent"]) {
    //     store
    //       .dispatch("student/getTrainingExamsResults")
    //       .then(() => loadedData++);
    //     store.dispatch("student/getProfessorsData").then(() => loadedData++);
    //     store.dispatch("student/getSubjects").then(() => loadedData++);
    //     console.log(loadedData);
    //     if (loadedData == 3) {
    //       NProgress.done();
    //       next();
    //     } else {
    //       next({ name: "network-issue" });
    //     }
    //     next();
    //   }
    //   next();
    // }
  },
  {
    name: "home",
    path: "/",
    redirect: {
      name: "dashboard",
    },
  },
  {
    name: "profile",
    path: "/profile",
    component: Profile,
    meta: {
      requiresAuth: true,
      layout: "layout",
    },
  },
];
