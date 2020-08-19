import UserServices from "../../services/UserServices";
import helpers from "../../services/helpers";
export default {
  namespaced: true,
  state: {
    user: null
  },
  getters: {
    userData: state => {
      return state.user;
    },
    loggedin: state => !!state.user,
    isStudent: state =>
      state.user != null ? state.user.roles.indexOf(1) != -1 : false,
    isProfessor: state =>
      state.user != null ? state.user.roles.indexOf(2) != -1 : false,
    isAdmin: state =>
      state.user != null ? state.user.roles.indexOf(3) != -1 : false
  },
  mutations: {
    SET_USER_DATA(state, userData) {
      this.isLoaded = true;
      state.user = userData;
      localStorage.setItem("user", JSON.stringify(userData));
      helpers.setToken(userData.token);
    },
    CLEAR_USER_DATA(state) {
      state.user = null;
      localStorage.removeItem("user");
      helpers.deleteToken();
      // axios.defaults.sheaders.common["Authorization"] = null;
      // location.reload(); //instead of removing data manually , reloading page will delete the state and axios
    },
    UPDATE_USER_DATA(state, data) {
      Object.keys(data).forEach(key => {
        state.user[key] = data[key];
      });
      localStorage.setItem("user", JSON.stringify(state.user));
    }
  },
  actions: {
    login({ commit }, credentials) {
      return UserServices.login(credentials).then(response =>
        commit("SET_USER_DATA", response.data.data)
      );
    },
    logout({ commit }) {
      commit("CLEAR_USER_DATA");
    },
    updateUserData({ commit }, data) {
      return UserServices.updateUserData(data).then(response => {
        commit("UPDATE_USER_DATA", data);
        return response.data.success;
      });
    },
    updateProfileImage({ commit }, image) {
      return UserServices.updateUserData(image).then(response => {
        commit("UPDATE_USER_DATA", response.data.images);
        // console.log(response.data);
        return response.data.success;
      });
    }
  }
};
