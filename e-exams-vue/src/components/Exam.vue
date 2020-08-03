<template>
  <div>
    <tr>
      <td class="d-inline-block exam-id">EX{{ exam.id }}</td>
      <td class="d-inline-block">{{ exam.subject }}</td>
      <td v-if="exam.success ==undefined" class="d-inline-block"></td>
      <td
        v-else
        class="d-inline-block"
        :class="{ success: exam.success, failed: !exam.success }"
      >{{ exam.success ? "Passed" : "Failed" }}</td>
      <td
        v-if="exam.success!=undefined"
        class="d-inline-block"
        :class="{ success: exam.success, failed: !exam.success }"
      >{{ exam.date }}</td>
      <td v-else class="d-inline-block"></td>
      <td class="d-inline-block">...</td>
    </tr>
  </div>
</template>

<script>
export default {
  props: {
    exam: {
      required: true,
      type: Object
    }
  }
};
</script>

<style scoped>
tr {
  display: block;
  padding-left: 10px;
}
tr:hover {
  background-color: #fff;
  box-shadow: 4px 3px 13px 0px rgba(0, 0, 0, 0.2);
  border-radius: 15px;
}

th,
td {
  width: 23%;
  text-align: left;
  padding: 10px 5px;
}
td:last-of-type {
  width: 5%;
}
.exam-id {
  color: #aaa;
}
.success {
  color: green;
}
.failed {
  color: #f00;
}
</style>