const strongPassword = password => {
  let regex = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
  );
  return regex.test(password);
};
import { required, sameAs } from "vuelidate/lib/validators";

export default {
  password: {
    required,
    strongPassword
  },
  c_password: {
    required,
    sameAsPassword: sameAs("password")
  }
};
