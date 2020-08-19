import FullNameAndAcademicIDValidation from "./FullNameAndAcademicIDValidation";
import passwordValidation from "./passwordValidation";
import { required, email } from "vuelidate/lib/validators";
import UserServices from "../services/UserServices";
export default {
  validations: {
    userData: {
      ...FullNameAndAcademicIDValidation,
      ...passwordValidation,
      email: {
        email,
        required,
        isUnique(email) {
          if (email == "") return true;
          return UserServices.checkIsUniqueEmail(this.new_email).then(
            response => response.data.unique
          );
        }
      },

      level: { required },
      department: { required }
    }
  }
};
