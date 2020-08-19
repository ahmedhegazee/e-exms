<template>
  <div class="form-group">
    <input class="form-control" v-bind="$attrs" :value="value" v-on="listeners" />
  </div>
</template>

<script>
import formFeildMixin from "../mixins/formFeildMixin";
export default {
  mixins: [formFeildMixin],
  inheritAttrs: false,
  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: this.updateValue
      };
    }
  }
};
</script>

<style scoped>
.error {
  border: 1px solid #f00;
}
</style>