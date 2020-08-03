<template>
  <div>
    <div class="aside">
      <div class="link ml-4 mb-2 pl-4" v-for="(link, index) in links" :key="index">
        <img src class="d-inline" alt />
        <router-link
          :to="{ name: link.name }"
          class="d-block"
          :class="{ active: $route.name === link.name }"
        >
          <i :class="link.icon"></i>
          <span class="ml-3">{{ link.label }}</span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: {
      required: true,
      type: Array
    }
  }
};
</script>

<style scoped>
.aside {
  height: 100vh;
}

.aside a,
.aside a:hover,
.aside a:visited {
  color: #acacac;
  text-decoration: none;
}
.active {
  color: #1bd371 !important;
}
</style>
