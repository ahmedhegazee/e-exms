import { required, minLength } from "vuelidate/lib/validators";

export default {
  fullname: {
    required,
    minLength: minLength(5),
    correctFullName(fullname) {
      let regex = new RegExp("[A-Za-z ]+");
      return regex.test(fullname);
    }
  },
  academicID: {
    required,
    correctAcademicID(academicID) {
      let regex = new RegExp("^[0-9]{16}");
      return regex.test(academicID);
    }
  }
};
