<template>
  <div :is="layout" v-if="layout!=''">
    <router-view></router-view>
  </div>
  <div v-else>
    <router-view></router-view>
  </div>
</template>

<script>
// import NavBar from "./components/NavBar";
import Main from "./modules/layouts/Main";
import Auth from "./modules/layouts/Auth";
export default {
  name: "App",
  mounted() {
    // let self = this;
    // setTimeout(function() {
    //   self.layout = self.$route.meta.layout;
    // }, 2000);
    this.layout = this.$route.meta.layout;
  },
  watch: {
    $route(newRoute, oldRoute) {
      this.layout = newRoute.meta.layout;
    }
  },
  components: { layout: Main, auth: Auth },
  data() {
    return {
      layout: ""
    };
  }
};
</script>

<style>
@font-face {
  font-family: "NexaBold";
  src: url("./assets/fonts/NexaBold.otf");
  font-weight: 400;
}
@font-face {
  font-family: "NexaLight";
  src: url("./assets/fonts/NexaLight.otf");
  font-weight: 200;
}
body {
  overflow-x: hidden;
  font-family: NexaBold !important;
}
#app {
  background-color: #f6f7fb;
  width: 100%;
  min-height: 93.3vh;
  padding-top: 10vh;
  padding-bottom: 10vh;
}
.container {
  background-color: #fff;
  padding: 30px 20px;
}
.header h3 {
  margin: 0;
}
.header span {
  font-size: 12pt;
  color: #a9a6a6;
}
.form-control,
.container .btn {
  border: 0;
  border-radius: 20px;
}
.form-control {
  padding: 25px;
  background-color: #5b8ef17a;
}
.container .btn {
  color: #ececec;
  font-size: 14pt;
  width: 100%;
  padding: 10px 0;
  background-color: #5b8ef1;
}
.container .btn:hover {
  background-color: #5b8ef1d4;
  color: #ffffff;
}
.error-message {
  color: #f00;
  font-size: 8pt;
}
</style>
<style src="./assets/styles/style.css">
</style>
