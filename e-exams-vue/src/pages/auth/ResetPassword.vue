<template>
  <div id="app">
    <div class="col-md-10 mt-4" style="margin:0 auto" v-if="errors.length!=0">
      <b-alert variant="danger" v-for="error in errors" :key="error" class="mb-2" show>{{error}}</b-alert>
    </div>
    <div class="container col-md-3 col-3">
      <div class="header text-center mb-3">
        <h3>Reset Password</h3>
      </div>
      <b-form @submit="onSubmit">
        <b-form-group id="input-group-1">
          <b-form-input
            id="input-1"
            type="email"
            required
            v-model="userData.email"
            :state="emailState"
            disabled
            placeholder="email"
          ></b-form-input>
          <b-form-invalid-feedback>Write a valid email</b-form-invalid-feedback>
        </b-form-group>
        <b-form-group id="input-group-password">
          <b-form-input
            id="password-input"
            v-model="userData.password"
            type="password"
            required
            placeholder="password"
            :state="passwordState"
          ></b-form-input>
          <b-form-invalid-feedback>the password should contain characters ,numbers and sepcial characters .</b-form-invalid-feedback>
        </b-form-group>

        <b-form-group id="input-group-password_confirmation">
          <b-form-input
            id="password_confirmation-input"
            v-model="userData.password_confirmation"
            type="password"
            required
            :state="confirmPasswordState"
            placeholder="confirm password"
          ></b-form-input>
          <b-form-invalid-feedback>confirm password correctly</b-form-invalid-feedback>
        </b-form-group>
        <b-button type="submit" variant="primary">Reset</b-button>
      </b-form>
      <div class="text-center mt-2">
        <router-link :to="{ name: 'login' }">You have account ? Login</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import UserServices from "../../services/UserServices";
export default {
  created() {
    let query = this.$route.query;
    this.userData.email = query.email;
    this.userData.token = query.token;
    UserServices.checkToken(this.userData.email, this.userData.token).catch(
      error => {
        if (error.response.data.message != undefined)
          this.$router.push({
            name: "message",
            query: {
              msg: error.response.data.message,
              type: "danger"
            }
          });
        // if (error.response.data.message != undefined)
        //     this.errors.push(error.response.data.message);
      }
    );
  },
  data() {
    return {
      userData: {
        email: "",
        password: "",
        password_confirmation: "",
        token: ""
      },
      errors: []
    };
  },
  computed: {
    emailState() {
      let email = this.userData.email;
      let regex = new RegExp(/\S+@\S+\.\S+/);
      if (email.length === 0) return null;
      return regex.test(email);
    },
    passwordState() {
      let password = this.userData.password;
      if (password.length === 0) return null;
      let regex = new RegExp(
        "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
      );
      return regex.test(password);
    },
    confirmPasswordState() {
      let password_confirmation = this.userData.password_confirmation;
      let password = this.userData.password;
      if (password_confirmation.length === 0) return null;
      return password === password_confirmation && this.passwordState;
    }
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();

      if (!this.passwordState) return;
      if (!this.confirmPasswordState) return;
      if (!this.emailState) return;
      UserServices.resetPassword(this.userData)
        .then(response => {
          if (response.status === 200)
            this.$router.push({
              name: "message",
              query: {
                msg: "Your password is changed successfully",
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
