<template>
  <router-link
    :to="{name:'subject-show',params:{id:subject.id}}"
    class="item subject col-md-2 mr-4"
    v-if="link"
  >
    <div>
      <i class="fas fa-file-signature"></i>
      <span class="d-block item-title mb-1">{{ subject.name }}</span>
      <h4>{{ subject.questions }}</h4>
    </div>
  </router-link>
  <div v-else class="item subject col-md-2 mr-4">
    <div>
      <i class="fas fa-file-signature"></i>
      <span class="d-block item-title mb-1">{{ subject.name }}</span>
      <h4>{{ subject.questions }}</h4>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    subject: {
      required: true,
      type: Object
    },
    link: {
      required: true,
      type: Boolean,
      default: true
    }
  }
};
</script>

<style scoped>
.subject {
  height: 170px;
}
.fa-file-signature {
  font-size: 40pt;
  color: #1bd371;
}
.item:hover .fa-file-signature {
  color: #fff;
}
</style>