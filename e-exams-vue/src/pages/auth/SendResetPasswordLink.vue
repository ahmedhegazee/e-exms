<template>
  <div id="app">
    <div class="col-md-10 mb-4" style="margin:0 auto" v-if="errors.length!=0">
      <b-alert variant="danger" v-for="error in errors" :key="error" class="mb-2" show>{{error}}</b-alert>
    </div>
    <div class="container col-md-3 col-3">
      <div class="header text-center mb-5">
        <h3>Send Reset Link</h3>
      </div>

      <b-form class="mb-4" @submit="resetPassword">
        <b-form-group id="input-group-1">
          <b-form-input
            id="input-1"
            type="email"
            required
            v-model="email"
            :state="emailState"
            placeholder="email"
          ></b-form-input>
          <b-form-invalid-feedback>Write a valid email</b-form-invalid-feedback>
        </b-form-group>
        <b-button type="submit" variant="primary">Reset Password</b-button>
      </b-form>
      <div class="text-center">
        <router-link :to="{name:'login'}">Login</router-link>or
        <router-link :to="{ name: 'register' }">Create account</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import UserServices from "../../services/UserServices";
export default {
  computed: {
    emailState() {
      let regex = new RegExp(/\S+@\S+\.\S+/);
      if (this.email.length === 0) return null;
      return regex.test(this.email);
    }
  },
  data() {
    return {
      email: "",
      errors: []
    };
  },
  methods: {
    resetPassword(evt) {
      evt.preventDefault();
      if (!this.emailState) return;
      UserServices.createToken({ email: this.email })
        .then(response => {
          this.$router.push({
            name: "message",
            query: {
              msg: response.data.message,
              type: "success"
            }
          });
        })
        .catch(error => {
          if (error.response.data.message != undefined)
            this.errors.push(error.response.data.message);
          for (let err in error.response.data.error)
            this.errors.push(error.response.data.error[err][0]);
        });
    }
  }
};
</script>

<style scoped>
</style>