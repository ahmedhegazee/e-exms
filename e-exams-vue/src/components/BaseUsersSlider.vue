<template>
  <div class="row mb-4 mt-4">
    <h4>Prof Staff</h4>
    <div class="staff shadow row bg-white">
      <user v-for="(user, index) in users" :user="user" :key="index" />
    </div>
  </div>
</template>

<script>
// import StudentServices from "@/services/StudentServices";
import user from "./User";
// import { mapGetters } from "vuex";

export default {
  components: {
    user
  },
  props: {
    users: {
      required: true,
      type: Array
    }
  }
  // mounted() {
  //   StudentServices.getProfessors().then(response => {
  //     this.profs = response.data.data;
  //   });
  // },
  // data() {
  //   return {
  //     profs: [
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 1",
  //         subject: "subject 1"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 2",
  //         subject: "subject 2"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 3",
  //         subject: "subject 3"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 4",
  //         subject: "subject 4"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 5",
  //         subject: "subject 5"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 6",
  //         subject: "subject 6"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 7",
  //         subject: "subject 7"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 8",
  //         subject: "subject 8"
  //       },
  //       {
  //         image: "https://picsum.photos/200/300",
  //         name: "prof 9",
  //         subject: "subject 9"
  //       }
  //     ]
  //   };
  // }
};
</script>

<style scoped>
.staff {
  padding: 20px 10px;
  overflow-x: scroll;
  width: 98%;
  flex-wrap: nowrap;
  background-color: #fff;
  border-radius: 15px;
}
</style>