<template>
  <div>
    <div>
      <div class="container">
        <!-- <span>E-exams</span> -->
        <router-link v-if="!isAuthenticated" :to="{ name: 'login' }"
          >Login</router-link
        >
        <span id="fullname" v-else>{{ userData.name }}</span>
        <div class="clear-fix"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    isAuthenticated() {
      return this.$store.getters["user/loggedin"];
    },
    userData() {
      return this.$store.getters["user/userData"];
    }
    // ...mapGetters(["user/loggedin"])
  }
};
</script>

<style scoped>
.container {
  padding: 10px 20px;
  background-color: #f6f7fb;
  margin: 0;
  min-width: 100%;
  color: #000;
  font-size: 14pt;
}
.container a,
#fullname {
  float: right;
  color: #000;
}
.container a:hover,
.container a:visited {
  color: #000;
  text-decoration: none;
}
.float-fix {
  clear: both;
}
</style>
