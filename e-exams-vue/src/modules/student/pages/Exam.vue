<template>
  <div>
    <div class="navbar row justify-content-between">
      <img src alt />
      <div>
        <span id="fullname">{{userData.full_name}}</span>
        <BaseImage :source="userData.thumbnail_image" alt width="30px" class="ml-2" />
      </div>
    </div>
    <div class="content">
      <b-alert variant="danger" style="margin: auto" :show="message!==''">{{message}}</b-alert>
      <div class="row">
        <div class="col-6">
          <h1>Official Exam</h1>
          <div class="form shadow">
            <input
              type="text"
              v-model="examCode"
              placeholder="Enter the code"
              class="mb-4"
              :class="{error:$v.examCode.$error}"
              value
              @blur="$v.examCode.$touch()"
            />
            <template v-if="$v.examCode.$error">
              <p class="error-message">Exam Code is required</p>
            </template>
            <button @click="checkExamCode">Go</button>
          </div>
        </div>
        <div class="col-6">
          <img src alt />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import ExamsServices from "../../../services/ExamsServices";
export default {
  computed: {
    userData() {
      return this.$store.getters["user/userData"];
    }
  },

  data() {
    return {
      examCode: "",
      message: ""
    };
  },
  validations: {
    examCode: {
      required
    }
  },
  methods: {
    checkExamCode() {
      this.$v.$touch();
      if (this.$v.$invalid) return;
      ExamsServices.checkExamCode(this.examCode).then(response => {
        if (response.data.error != undefined) {
          this.message = response.data.error;
        } else {
          this.$store.commit("exam/SET_EXAM_AND_QUESTIONS", response.data);
          this.$router.push({ name: "solve-exam" });
        }
      });
    }
  }
};
</script>

<style scoped>
.navbar {
  height: 13vh;
  padding: 0 60px;
}
.content {
  padding: 10%;
  background-color: #f6f7fb;
  height: 87vh;
}
.content h1 {
  color: #cccccc;
  font-size: 48pt;
}
.form {
  background-color: #fff;
  border-radius: 10px;
  padding: 50px 40px;
}
.form input {
  width: 100%;
  border: 0;
  border-bottom: 1px solid #1bd371;
}
.form input::placeholder {
  font-size: 8pt;
  font-weight: 200;
  color: #aaa;
}
.form button {
  margin: 0 auto;
  border: 0;
  padding: 2px 70px;
  border-radius: 10px;
  font-size: 8pt;
  color: #fff;
  background-color: #1bd371;
  display: block;
}
</style>