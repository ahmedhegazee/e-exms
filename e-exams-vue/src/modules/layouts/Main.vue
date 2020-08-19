<template>
  <div id="app">
    <div class="row">
      <div class="col-2 p-3 bg-white">
        <Aside :links="links" />
      </div>
      <div class="col-10 pt-3">
        <div class="navbar" v-if="userData">
          <span id="fullname">{{userData.full_name}}</span>
          <BaseImage :source="userData.thumbnail_image" alt width="30px" class="ml-2" />
        </div>
        <div class="content pl-5">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Aside from "../../components/Aside";
import { mapGetters } from "vuex";
export default {
  mounted() {
    const studentLinks = [
      {
        name: "dashboard",
        label: "Dashboard",
        icon: "fas fa-th-large"
      },
      {
        name: "student-dashboard",
        label: "Traing Exam",
        icon: "fas fa-dumbbell"
      },
      {
        name: "analytics",
        label: "Analytics",
        icon: "fas fa-chart-line"
      },
      { name: "profile", label: "Profile", icon: "fas fa-user" },
      {
        name: "exam",
        label: "Official Exam",
        icon: "fas fa-file-alt"
      },
      {
        name: "logout",
        label: "Logout",
        icon: "fas fa-arrow-left"
      }
    ];
    const professorLinks = [
      {
        name: "dashboard",
        label: "Dashboard",
        icon: "fas fa-th-large"
      },
      {
        name: "professor-subject",
        label: "Subject",
        icon: "fas fa-font"
      },
      {
        name: "analytics",
        label: "Analytics",
        icon: "fas fa-chart-line"
      },
      { name: "profile", label: "Profile", icon: "fas fa-user" },
      {
        name: "exam",
        label: "Exam",
        icon: "fas fa-file-alt"
      },
      {
        name: "logout",
        label: "Logout",
        icon: "fas fa-arrow-left"
      }
    ];
    if (this.isStudent) this.links = studentLinks;
    if (this.isProfessor) this.links = professorLinks;
  },
  computed: {
    ...mapGetters("user", ["userData", "isProfessor", "isAdmin", "isStudent"])
  },
  components: {
    Aside
  },

  data() {
    return {
      links: []
    };
  }
};
</script>

<style scoped>
#app {
  padding-top: 0;
  padding-bottom: 0;
}

#fullname {
  color: #000;
  font-weight: 300;
  font-size: 10pt;
}
.navbar {
  justify-content: flex-end;
}
</style>
