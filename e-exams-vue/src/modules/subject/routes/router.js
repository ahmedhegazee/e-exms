import SubjectShow from "../pages/Show";
import SubjectServices from "../../../services/SubjectServices";
import store from "@/store/store";
export default [
  {
    path: "/subject/:id",
    name: "subject-show",
    component: SubjectShow,
    props: true,
    meta: {
      requiresAuth: true,
      layout: "layout",
    },
    beforeEnter: (to, from, next) => {
      SubjectServices.getSubjectChapters(to.params.id)
        .then((response) => {
          to.params.subject = response.data;
          next();
        })
        .catch((error) => {
          if (error.response && error.response.status == 404)
            next({ name: "404" });
          else next({ name: "network-issue" });
        });
    },
    // children: [
    //   {
    //     path: "chapter/:chapterId/questions",
    //     name: "chapter-show",
    //     component: ChapterQuestions,
    //     beforeEnter: (to, from, next) => {
    //       SubjectServices.getSubjectChapters(to.params.id)
    //         .then(response => {
    //           to.params.subject = response.data;
    //           next();
    //         })
    //         .catch(error => {
    //           if (error.response && error.response.status == 404)
    //             next({ name: "404" });
    //           else next({ name: "network-issue" });
    //         });
    //     }
    //   }
    // ]
  },
];
