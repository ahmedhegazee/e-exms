<template>
  <div class="skipped-questions" style="z-index:1">
    <div class="row justify-content-center">
      <div class="exit-dialog bg-white">
        <h5 class="mb-4">Add Chapter</h5>
        <button class="close" @click="closeDailogue">
          <i class="fas fa-times"></i>
        </button>
        <input
          type="text"
          class="mb-3"
          v-model="chapter.name"
          placeholder="Chapter Name"
          @blur="$v.chapter.name.$touch()"
        />
        <input
          type="text"
          class="mb-3"
          v-model.number="chapter.num"
          placeholder="Chapter Number"
          @blur="$v.chapter.num.$touch()"
        />
        <button @click="addChapter">Add</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { required, numeric, minLength } from "vuelidate/lib/validators/";
export default {
  data() {
    return {
      chapter: {
        name: "",
        num: ""
      }
    };
  },
  validations: {
    chapter: {
      name: {
        required,
        minLength: minLength(5)
        // uniqueName(name) {
        //   if (name == "") return true;
        //   const self = this;
        //   return (
        //     this.currentSubject.chapters.filter(function(chapter) {
        //       return chapter.name == self.chapter.name;
        //     }).length == 0
        //   );
        // }
      },
      num: {
        required,
        numeric,
        uniqueNum(num) {
          if (num == "") return true;
          const self = this;
          return (
            this.currentSubject.chapters.filter(function(chapter) {
              return chapter.num == self.chapter.num;
            }).length == 0
          );
        }
      }
    }
  },
  computed: {
    ...mapGetters("professor", ["currentSubject"])
  },
  methods: {
    reset() {
      this.chapter = {
        name: "",
        num: ""
      };
    },
    addChapter() {
      this.$v.$touch();
      if (this.$v.$invalid) return;

      this.$emit("newChapter", {
        chapter_title: this.chapter.name,
        chapter_num: this.chapter.num
      });
      this.closeDailogue();
    },
    closeDailogue(event) {
      this.reset();
      this.$emit("closeDialogue");
    }
  }
};
</script>

<style scoped>
.skipped-questions {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.3);
}
.exit-dialog {
  margin-top: 30vh;
  width: 35%;
  height: 30vh;
  padding: 20px 30px;
  border-radius: 15px;
  position: relative;
}
.exit-dialog h5 {
  font-size: 12pt;
  color: #1bd371;
}
.exit-dialog button {
  width: 100%;
  border: 1px solid #1bd371;
  padding: 5px;
  font-size: 10pt;
  background-color: #1bd371;
  color: #fff;
}
.exit-dialog input {
  width: 100%;
  display: block;
  border: 0;
  border-bottom: 1px solid #acacac;
}
.exit-dialog input::placeholder {
  font-size: 10pt;
}
.close {
  position: absolute;
  background-color: transparent !important;
  border: none !important;
  top: 10%;
  right: 5%;
  font-size: 10pt;
  text-align: right;
  width: 5% !important;
}
.fa-times {
  color: #acacac !important;
}
.fa-times:hover {
  cursor: pointer;
}
</style>