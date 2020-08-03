import Vue from "vue";
import App from "./App.vue";
import upperFirst from "lodash/upperFirst";
import camelCase from "lodash/camelCase";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import NProgress from "nprogress";
import "nprogress/nprogress.css";
import Vuelidate from "vuelidate";
import store from "./store/store";
import router from "./routes/router";
import "@fortawesome/fontawesome-free/css/all.css";
import "@fortawesome/fontawesome-free/js/all.js";
import helpers from "./services/helpers";
Vue.use(BootstrapVue);
Vue.use(NProgress);
Vue.use(Vuelidate);

const requireComponent = require.context(
  "./components",
  false,
  /Base[A-Z]\w+\.(vue|js)$/
);

requireComponent.keys().forEach((fileName) => {
  const componentConfig = requireComponent(fileName);

  const componentName = upperFirst(
    camelCase(fileName.replace(/^\.\/(.*)\.\w+$/, "$1"))
  );

  Vue.component(componentName, componentConfig.default || componentConfig);
});
Vue.config.productionTip = false;

new Vue({
  store,
  router,

  mounted() {
    // console.log("hello");
    const userData = localStorage.getItem("user");
    if (userData) {
      let data = JSON.parse(userData);
      let expireDate = new Date(data.token_expire);
      let today = new Date();
      if (today <= expireDate) store.commit("user/SET_USER_DATA", data);
      // this.$router.push({ name: "dashboard" });
    }
    helpers.getInstance().interceptors.response.use(
      (response) => response,
      (error) => {
        if (error.response.status === 401) this.$store.dispatch("user/logout");
        return Promise.reject(error);
      }
    );
  },
  render: (h) => h(App),
}).$mount("#app");
