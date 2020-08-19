<template>
  <div id="app">
    <Message :type="type" :message="message" />
    <div class="container col-md-3 col-3">
      <div class="header text-center mb-5">
        <h3>Welcome back</h3>
        <span>Enter your credentials to login</span>
      </div>
      <form class="mb-4" @submit.prevent>
        <!-- <div class="form-group">
          <input
            v-model="email"
            type="email"
            placeholder="email"
            class="form-control"
            :class="{error:$v.email.$error}"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            @blur="$v.email.$touch()"
          />
          <template v-if="$v.email.$error">
            <p class="error-message p-2" v-if="!$v.email.required">Email is required</p>
            <p class="error-message p-2" v-if="!$v.email.email">Write correct email</p>
          </template>
        </div>-->
        <BaseInput
          v-model="email"
          :class="{error:$v.email.$error}"
          @blur="$v.email.$touch()"
          placeholder="email"
          type="email"
        />
        <template v-if="$v.email.$error">
          <p class="error-message p-1" v-if="!$v.email.required">Email is required</p>
          <p class="error-message p-1" v-if="!$v.email.email">Write correct email</p>
        </template>
        <BaseInput
          v-model="password"
          type="password"
          placeholder="password"
          :class="{error:$v.password.$error}"
          @blur="$v.password.$touch()"
        />
        <template v-if="$v.password.$error">
          <p class="error-message p-1" v-if="!$v.password.required">Password is required</p>
        </template>
        <!-- <div class="form-group">
          <input
            v-model="password"
            type="password"
            placeholder="password"
            class="form-control"
            :class="{error:$v.password.$error}"
            id="exampleInputPassword1"
            @blur="$v.password.$touch()"
          />
          <template v-if="$v.password.$error">
            <p class="error-message p-2" v-if="!$v.password.required">Password is required</p>
          </template>
        </div>-->
        <button @click="login" type="button" class="btn text-center">Login</button>
      </form>
      <div class="text-center">
        <router-link :to="{name:'reset-password-link'}">Reset password</router-link>or
        <router-link :to="{ name: 'register' }">Create account</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";
import Message from "../../components/Message.vue";
import { messageMixin } from "../../mixins/messageMixin";
export default {
  mixins: [messageMixin],
  components: {
    Message
  },
  data() {
    return {
      email: "",
      password: ""
    };
  },
  validations: {
    email: {
      required,
      email
    },
    password: {
      required
    }
  },

  methods: {
    login() {
      this.$v.$touch();
      if (this.$v.$invalid) return;
      this.$store
        .dispatch("user/login", {
          email: this.email,
          password: this.password
        })
        .then(() => {
          // if (this.$store.getters["user/isStudent"])

          this.$router.push({ name: "dashboard" });
        })
        .catch(error => {
          if (error.response.status === 401) {
            this.type = "danger";
            this.message = error.response.data.error;
          }
        });
    }
  }
};
</script>

<style scoped>
</style>
