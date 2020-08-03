<template>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="nameInput">Name</label>
        <span>
          <input
            type="text"
            class="form-control"
            id="nameInput"
            v-model="fullname"
            placeholder="full name"
            aria-describedby="nameHelp"
            :class="{ error: $v.fullname.$error }"
            @blur="$v.fullname.$touch()"
          />
        </span>
        <template v-if="$v.fullname.$error">
          <p class="error-message p-1" v-if="!$v.fullname.required">Full name is required</p>
          <p
            class="error-message p-1"
            v-if="
              $v.fullname.required &&
                !$v.fullname.correctFullName
            "
          >Write correct full name</p>
          <p
            class="error-message p-1"
            v-if="!$v.fullname.minLength"
          >full name must be at least 5 characters</p>
        </template>
      </div>
      <div class="form-group">
        <label for="academicNumberInput">Academic Number</label>
        <span>
          <input
            type="text"
            class="form-control"
            v-model="academicID"
            placeholder="academic ID"
            id="academicNumberInput"
            :class="{ error: $v.academicID.$error }"
            @blur="$v.academicID.$touch()"
          />
        </span>
        <template v-if="$v.academicID.$error">
          <p class="error-message p-1" v-if="!$v.academicID.required">Academic ID is required</p>
          <p
            class="error-message p-1"
            v-if="
              $v.academicID.required &&
                !$v.academicID.correctAcademicID
            "
          >Write correct academic ID</p>
        </template>
      </div>
      <!-- <div class="form-group">
    <label for="levelInput">Level</label>
    <select class="form-control" id="levelInput">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
      </div>-->
    </div>
    <div class="col-md-4">
      <BaseImage :source="source" v-if="source" id="img" class="w-100" @click="openFileWindow" />
      <input
        type="file"
        class="d-none"
        id="profileImage"
        @change="changeImageSource"
        accept="image/png, image/jpeg"
      />
      <span class="title d-block" @click="openFileWindow">Change Image</span>
      <template v-if="$v.image.$error">
        <p
          class="error-message p-1"
          v-if="
              !$v.image.fileSizeValidation 
            "
        >The size of the image is too big. must be less than 2 mb</p>
      </template>
    </div>

    <BaseButton @click.native="updateData" />
  </div>
</template>

<script>
const fileSizeValidation = (file, vm) => {
  if (!file) return true;
  return file.size <= 2097152;
};
import { mapGetters } from "vuex";
import UserServices from "../../services/UserServices";
import FullNameAndAcademicIDValidation from "../../mixins/FullNameAndAcademicIDValidation";
export default {
  mounted() {
    this.source = this.userData.original_image;
    this.fullname = this.userData.full_name;
    this.academicID = this.userData.academic_id;
  },
  computed: {
    ...mapGetters("user", ["userData"])
  },
  validations: {
    ...FullNameAndAcademicIDValidation,
    image: {
      fileSizeValidation
    }
  },
  data() {
    return {
      source: "",
      image: null,
      fullname: "",
      academicID: ""
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

      let data = {};
      if (this.fullname != this.userData.full_name)
        data["full_name"] = this.fullname;
      if (this.academicID != this.userData.academic_id)
        data["academic_id"] = this.academicID;
      if (this.image != null) {
        let data = new FormData();
        data.append("image", this.image);
        this.$store
          .dispatch("user/updateProfileImage", data)
          .then(() => {
            this.$emit("messageUpdate", {
              message: "Profile image is uploaded successfully",
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
      if (Object.keys(data).length > 0) {
        this.$store
          .dispatch("user/updateUserData", data)
          .then(success => {
            this.$emit("messageUpdate", {
              message: success,
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
      //  else {
      //   this.$emit("messageUpdate", {
      //     message: "You didn't change your data",
      //     variant: "danger"
      //   });
      // }
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