<template>
  <div class="row">
    <div class="col-md-10">
      <div class="form-group">
        <label for="currentPasswordInput">Current Password</label>
        <span>
          <input
            class="form-control"
            id="currentPasswordInput"
            v-model="current_password"
            :class="{ error: $v.current_password.$error }"
            @blur="$v.current_password.$touch()"
            placeholder="current password"
            type="password"
            aria-describedby="currentPasswordHelp"
          />
        </span>
        <template v-if="$v.current_password.$error">
          <p
            class="error-message p-1"
            v-if="!$v.current_password.required"
          >Current Password is required</p>
          <p
            class="error-message p-1"
            v-if="!$v.current_password.isCurrent"
          >Write your current password correctly</p>
        </template>
      </div>
      <div class="form-group">
        <label for="newPasswordInput">New Password</label>
        <span>
          <input
            class="form-control"
            id="newPasswordInput"
            v-model="password"
            :class="{ error: $v.password.$error }"
            @blur="$v.password.$touch()"
            placeholder="new password"
            type="password"
            aria-describedby="newPasswordHelp"
          />
        </span>
        <template v-if="$v.password.$error">
          <p class="error-message p-1" v-if="!$v.password.required">new password is required</p>
          <p
            class="error-message p-1"
            v-if="
              $v.password.required &&
                !$v.password.strongPassword
            "
          >
            Write strong password that shoul have 8 characters , numbers ,
            capital characters and special characters
          </p>
        </template>
      </div>
      <div class="form-group">
        <label for="confirmpasswordInput">Confirm password</label>
        <span>
          <input
            class="form-control"
            id="confirmpasswordInput"
            v-model="c_password"
            :class="{ error: $v.c_password.$error }"
            @blur="$v.c_password.$touch()"
            placeholder="confirm password"
            type="password"
            aria-describedby="confirmPasswordHelp"
          />
        </span>
        <template v-if="$v.c_password.$error">
          <p
            class="error-message p-1"
            v-if="!$v.c_password.required"
          >confirming password is required</p>
          <p
            class="error-message p-1"
            v-if="!$v.c_password.sameAsPassword"
          >confirm your password correctly</p>
        </template>
      </div>
    </div>

    <BaseButton @click.native="updateData" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import UserServices from "../../services/UserServices";
import { required } from "vuelidate/lib/validators";
import passwordValidation from "../../mixins/passwordValidation";
export default {
  validations: {
    current_password: {
      required,
      isCurrent(password) {
        if (password == "") return true;
        return UserServices.checkIsCurrentPassword(this.current_password).then(
          response => {
            return response.data.current;
          }
        );
      }
    },
    ...passwordValidation
  },
  data() {
    return {
      current_password: "",
      password: "",
      c_password: ""
    };
  },
  methods: {
    openFileWindow() {
      document.getElementById("profileImage").click();
    },
    changeImageSource(event) {
      const file = event.target.files[0];
      this.image = file;
      this.source = URL.createObjectURL(file);
      this.$v.image.$touch();
    },
    updateData() {
      this.$v.$touch();
      if (this.$v.$invalid) return;

      UserServices.updateUserData({
        current_password: this.current_password,
        new_password: this.password
      })
        .then(() => {
          this.$emit("messageUpdate", {
            message: "Password is updated successfully",
            variant: "success"
          });
        })
        .catch(error => {
          this.$emit("messageUpdate", {
            message: "Something is going wrong",
            variant: "danger"
          });
        });
    }
  }
};
</script>

<style scoped>
img {
  height: auto !important;
}
.title {
  font-size: 8pt;
  font-weight: 400;
  color: #1bd371;
  text-align: center;
}
.title:hover,
img:hover {
  cursor: pointer;
}
.form-group input {
  border: 0;
  padding-left: 0;
}
.form-group span {
  border-bottom: 2px solid #dedede;
  display: block;
}
.form-group label {
  font-weight: 400;
  font-size: 10pt;
}
.form-group input::placeholder,
.form-group input {
  font-size: 10pt;
  font-weight: 400;
}
</style>