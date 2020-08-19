<template>
  <div id="app">
    <div class="col-md-10" style="margin:0 auto">
      <b-alert :variant="type" show>{{message}}</b-alert>
    </div>
  </div>
</template>

<script>
import UserServices from "../../services/UserServices";
export default {
  data() {
    return {
      message: "",
      type: "success"
    };
  },
  mounted() {
    UserServices.verifyUser(this.id)
      .then(response => {
        if (response.status === 200)
          this.message = "You are verified successfully";
      })
      .catch(error => {
        this.message = "Failed Verification of the user :" + error.message;
        this.type = "danger";
      });
  },
  props: ["id"]
};
</script>

<style lang="scss" scoped>
</style>