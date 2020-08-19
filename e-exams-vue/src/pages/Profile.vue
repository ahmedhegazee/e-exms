<template>
  <div>
    <b-alert
      :show="dismissCountDown"
      dismissible
      :variant="variant"
      @dismissed="resetAlert"
      @dismiss-count-down="countDownChanged"
    >
      <p>{{message}}</p>
    </b-alert>
    <div class="row pt-3 pb-5 pr-2 pl-2 items-container">
      <div
        v-for="(setting,index) in settings"
        :key="index"
        class="item subject col-md-2 mr-4"
        :class="{ active: component === setting.name }"
        @click="component=setting.name"
      >
        <i :class="setting.icon"></i>
        <span class="d-block item-title mb-1 mt-2">{{ setting.label }}</span>
      </div>
    </div>
    <div class="row">
      <div class="settings-container shadow col-md-6">
        <div :is="component" @messageUpdate="showMessage"></div>
      </div>
    </div>
  </div>
</template>

<script>
const profileSettings = [
  {
    label: "perosnal info",
    name: "perosnal-info",
    icon: "fas fa-user"
  },
  {
    label: "password",
    name: "password",
    icon: "fas fa-key"
  },
  {
    label: "email",
    name: "email",
    icon: "fas fa-envelope"
  }
];
const studentProfilSettings = [
  {
    label: "scores",
    name: "scores",
    icon: "fas fa-font"
  }
];
import PerosnalInfo from "../components/settings/PersonalInfo";
import Email from "../components/settings/Email";
import Password from "../components/settings/Password";
export default {
  components: {
    PerosnalInfo,
    Email,
    Password
  },
  mounted() {
    if (this.$store.getters["user/isStudent"]) {
      this.settings = profileSettings.concat(studentProfilSettings);
    } else {
      this.settings = profileSettings;
    }
  },
  data() {
    return {
      settings: [],
      component: "perosnal-info",
      dismissSecs: 5,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      message: "",
      variant: ""
    };
  },
  methods: {
    showMessage(event) {
      this.message = event.message;
      this.variant = event.variant;
      this.dismissCountDown = this.dismissSecs;
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    resetAlert() {
      this.dismissCountDown = 0;
      this.message = "";
    }
  }
};
</script>

<style scoped>
.fa-user,
.fa-key,
.fa-envelope,
.fa-font {
  font-size: 20pt;
  color: #fff;
}
.item {
  background-color: #1bd371;
  font-weight: 400;
  color: #fff;
  padding: 20px 30px;
}
.item:hover,
.active {
  background-color: #fff;
  color: #000;
}
.item:hover .fa-user,
.item:hover .fa-key,
.item:hover .fa-envelope,
.item:hover .fa-font,
.active .fa-user,
.active .fa-key,
.active .fa-envelope,
.active .fa-font {
  color: #1bd371;
}
.item-title {
  font-size: 8pt;
}
.settings-container {
  border-radius: 15px;
  background-color: #fff;
  padding-top: 40px;
  padding-left: 30px;
  padding-bottom: 30px;
}
</style>