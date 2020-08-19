<template>
  <div class="row">
    <div class="col-md-10">
      <div class="form-group">
        <label for="currentEmailInput">Current Email</label>
        <span>
          <input
            class="form-control"
            id="currentEmailInput"
            v-model="current_email"
            :class="{ error: $v.current_email.$error }"
            @blur="$v.current_email.$touch()"
            placeholder="current email"
            type="email"
            aria-describedby="currentEmailHelp"
          />
        </span>
        <template v-if="$v.current_email.$error">
          <p class="error-message p-1" v-if="!$v.current_email.required">Current Email is required</p>
          <p class="error-message p-1" v-if="!$v.current_email.email">Write correct email</p>
          <p
            class="error-message p-1"
            v-if="!$v.current_email.isCurrent"
          >Write your current email correctly</p>
        </template>
      </div>
      <div class="form-group">
        <label for="newEmailInput">New Email</label>
        <span>
          <input
            class="form-control"
            id="newEmailInput"
            v-model="new_email"
            :class="{ error: $v.new_email.$error }"
            @blur="$v.new_email.$touch()"
            placeholder="new email"
            type="email"
            aria-describedby="newEmailHelp"
          />
        </span>
        <template v-if="$v.new_email.$error">
          <p class="error-message p-1" v-if="!$v.new_email.required">New Email is required</p>
          <p class="error-message p-1" v-if="!$v.new_email.email">Write correct email</p>
          <p class="error-message p-1" v-if="!$v.new_email.isUnique">This email is token</p>
        </template>
      </div>
      <div class="form-group">
        <label for="confirmEmailInput">Confirm Email</label>
        <span>
          <input
            class="form-control"
            id="confirmEmailInput"
            v-model="confirm_email"
            :class="{ error: $v.confirm_email.$error }"
            @blur="$v.confirm_email.$touch()"
            placeholder="confirm email"
            type="email"
            aria-describedby="confirmEmailHelp"
          />
        </span>
        <template v-if="$v.confirm_email.$error">
          <p class="error-message p-1" v-if="!$v.confirm_email.required">Confirm Email is required</p>
          <p
            class="error-message p-1"
            v-if="!$v.confirm_email.sameAsEmail&&$v.confirm_email.required"
          >confirm your new email correctly</p>
        </template>
      </div>
    </div>

    <BaseButton @click.native="updateData" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import UserServices from "../../services/UserServices";
import { email, required, sameAs } from "vuelidate/lib/validators";
export default {
  validations: {
    current_email: {
      email,
      required,
      isCurrent(email) {
        if (email == "") return true;
        return UserServices.checkIsCurrentEmail(this.current_email).then(
          response => {
            // console.log(response.data.current);
            return response.data.current;
          }
        );
      }
    },
    new_email: {
      email,
      required,
      isUnique(email) {
        if (email == "") return true;
        return UserServices.checkIsUniqueEmail(this.new_email).then(
          response => response.data.unique
        );
      }
    },
    confirm_email: {
      required,
      sameAsEmail: sameAs("new_email")
    }
  },
  data() {
    return {
      current_email: "",
      new_email: "",
      confirm_email: ""
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
        email: this.new_email,
        current_email: this.current_email
      })
        .then(() => {
          this.$emit("messageUpdate", {
            message: "Email is updated successfully",
            variant: "success"
          });
        })
        .catch(error => {
          this.$emit("messageUpdate", {
            message: "Something is going wrong",
            variant: "danger"
          });
        });
      // data["image"] = this.image;
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