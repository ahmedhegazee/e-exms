<template>
  <div id="app">
    <Message :type="type" :message="message" />

    <div v-if="form" class="container col-md-3 col-3">
      <div class="header text-center mb-3">
        <h3>Register as student</h3>
        <span>Create new account</span>
      </div>
      <form class="mb-4" @submit.prevent>
        <BaseInput
          v-model="userData.fullname"
          :class="{ error: $v.userData.fullname.$error }"
          @blur="$v.userData.fullname.$touch()"
          placeholder="full name"
          type="text"
        />
        <template v-if="$v.userData.fullname.$error">
          <p class="error-message p-1" v-if="!$v.userData.fullname.required">Full name is required</p>
          <p
            class="error-message p-1"
            v-if="
              $v.userData.fullname.required &&
                !$v.userData.fullname.correctFullName
            "
          >Write correct full name</p>
          <p
            class="error-message p-1"
            v-if="!$v.userData.fullname.minLength"
          >full name must be at least 5 characters</p>
        </template>
        <BaseInput
          v-model="userData.email"
          :class="{ error: $v.userData.email.$error }"
          @blur="$v.userData.email.$touch()"
          placeholder="email"
          type="email"
        />
        <template v-if="$v.userData.email.$error">
          <p class="error-message p-1" v-if="!$v.userData.email.required">Email is required</p>
          <p class="error-message p-1" v-if="!$v.userData.email.email">Write correct email</p>
          <p class="error-message p-1" v-if="!$v.userData.email.isUnique">This email is token</p>
        </template>
        <BaseInput
          v-model="userData.password"
          :class="{ error: $v.userData.password.$error }"
          @blur="$v.userData.password.$touch()"
          placeholder="password"
          type="password"
        />
        <template v-if="$v.userData.password.$error">
          <p class="error-message p-1" v-if="!$v.userData.password.required">password is required</p>
          <p
            class="error-message p-1"
            v-if="
              $v.userData.password.required &&
                !$v.userData.password.strongPassword
            "
          >
            Write strong password that shoul have 8 characters , numbers ,
            capital characters and special characters
          </p>
        </template>
        <BaseInput
          v-model="userData.c_password"
          :class="{ error: $v.userData.c_password.$error }"
          @blur="$v.userData.c_password.$touch()"
          placeholder="confirm password"
          type="password"
        />
        <template v-if="$v.userData.c_password.$error">
          <p
            class="error-message p-1"
            v-if="!$v.userData.c_password.required"
          >confirming password is required</p>
          <p
            class="error-message p-1"
            v-if="!$v.userData.c_password.sameAsPassword"
          >confirm your password correctly</p>
        </template>
        <BaseInput
          v-model="userData.academicID"
          :class="{ error: $v.userData.academicID.$error }"
          @blur="$v.userData.academicID.$touch()"
          placeholder="academic ID"
          type="text"
        />
        <template v-if="$v.userData.academicID.$error">
          <p
            class="error-message p-1"
            v-if="!$v.userData.academicID.required"
          >Academic ID is required</p>
          <p
            class="error-message p-1"
            v-if="
              $v.userData.academicID.required &&
                !$v.userData.academicID.correctAcademicID
            "
          >Write correct academic ID</p>
        </template>

        <div class="form-group">
          <select
            class="form-control"
            v-model.number="userData.level"
            @change="getDepartments"
            @blur="$v.userData.level.$touch()"
          >
            <option disabled>Select Level</option>
            <option
              :value="level.id"
              v-for="(level, index) in levels"
              :key="index"
            >{{ level.level }}</option>
          </select>

          <template v-if="$v.userData.level.$error">
            <p class="error-message p-1" v-if="!$v.userData.level.required">Level is required</p>
          </template>
        </div>
        <div class="form-group">
          <select
            class="form-control"
            v-model.number="userData.department"
            @blur="$v.userData.department.$touch()"
          >
            <option disabled>Select Department</option>
            <option
              :value="department.id"
              v-for="(department, index) in departments"
              :key="index"
            >{{ department.title }}</option>
          </select>
          <template v-if="$v.userData.level.$error">
            <p class="error-message p-1" v-if="!$v.userData.level.required">Department is required</p>
          </template>
        </div>

        <button @click="register" type="button" class="btn text-center">Register</button>
      </form>
      <div class="text-center mt-2">
        <router-link :to="{ name: 'login' }">You have account ? Login</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import UserServices from "../../services/UserServices";
import Message from "../../components/Message.vue";
import { messageMixin } from "../../mixins/messageMixin";
import FormValidation from "../../mixins/FormValidations";

export default {
  mixins: [messageMixin, FormValidation],
  mounted() {
    UserServices.getLevels().then(
      response => (this.levels = response.data.data)
    );
  },
  components: {
    Message
  },
  data() {
    return {
      userData: {
        email: "",
        password: "",
        c_password: "",
        fullname: "",
        academicID: "",
        level: "",
        department: ""
      },
      levels: [],
      departments: [],
      message: "",
      type: "",
      form: true
    };
  },

  methods: {
    register() {
      this.$v.$touch();
      if (this.$v.$invalid) return;

      UserServices.register({
        full_name: this.userData.fullname,
        password: this.userData.password,
        c_password: this.userData.c_password,
        email: this.userData.email,
        academic_id: this.userData.academicID,
        level_id: this.userData.level,
        department_id: this.userData.department
      })
        .then(response => {
          this.message = response.data.success.message;
          this.type = "success";
          this.form = false;
        })
        .catch(error => {
          this.message = error.response.data.error.join(" ");
          this.type = "danger";
        });
    },

    getDepartments(event) {
      UserServices.getDepartments(event.target.value).then(response => {
        this.departments = response.data.data;
      });
    }
  }
};
</script>

<style scoped></style>
