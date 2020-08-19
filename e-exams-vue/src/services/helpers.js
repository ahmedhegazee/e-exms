import axios from "axios";
let instance = axios.create({
  baseURL: "https://e-exams.devhegz/api/",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
  timeout: 30000,
});
export default {
  getInstance() {
    return instance;
  },
  setToken(token) {
    instance.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  },
  deleteToken() {
    instance.defaults.headers.common["Authorization"] = null;
  },
};
