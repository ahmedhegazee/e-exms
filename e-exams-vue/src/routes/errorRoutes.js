import NetworkIssue from "@/pages/errors/NetworkIssue.vue";
import NotFound from "@/pages/errors/NotFound.vue";
export default [
  {
    path: "/404",
    name: "404",
    component: NotFound,
    props: true
  },
  {
    path: "/network-issue",
    name: "network-issue",
    component: NetworkIssue
  },
  {
    path: "*",
    redirect: { name: "404", params: { resource: "page" } }
  }
];
