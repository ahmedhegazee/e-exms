import helpers from "./helpers";
export default {
  login(credentials) {
    return helpers.getInstance().post("login", credentials);
  },
  register(userData) {
    return helpers.getInstance().post("register", userData);
  },
  createToken(email) {
    return helpers.getInstance().post("password/create", email);
  },
  checkToken(email, token) {
    return helpers.getInstance().get(`password/find/${token}/${email}`);
  },
  resetPassword(credentials) {
    return helpers.getInstance().post("password/reset", credentials);
  },
  verifyUser(id) {
    return helpers.getInstance().get(`email/verify/${id}`);
  },
  getLevels() {
    return helpers.getInstance().get("level");
  },
  getDepartments(level) {
    return helpers.getInstance().get(`level/${level}/dept`);
  },
  updateUserData(data) {
    return helpers.getInstance().post("user/update", data);
  },
  checkIsUniqueEmail(email) {
    return helpers.getInstance().post("unique/email", { email });
  },
  checkIsCurrentEmail(email) {
    return helpers.getInstance().post("current/email", { email });
  },
  checkIsCurrentPassword(password) {
    return helpers.getInstance().post("current/password", { password });
  }
};
