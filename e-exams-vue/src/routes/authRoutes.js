import Login from "@/pages/auth/Login.vue";
import Register from "@/pages/auth/Register.vue";
// import Message from "@/pages/Message.vue";
import SendResetPasswordLink from "@/pages/auth/SendResetPasswordLink.vue";
import ResetPassword from "@/pages/auth/ResetPassword.vue";
import Verification from "@/pages/auth/Verification.vue";
import Logout from "@/pages/auth/Logout.vue";
export default [
  {
    path: "/login",
    component: Login,
    name: "login",
    meta: {
      auth: true,
      layout: "auth",
    },
  },
  {
    path: "/register",
    component: Register,
    name: "register",
    meta: {
      auth: true,
      layout: "auth",
    },
  },
  // {
  //   path: "/message",
  //   component: Message,
  //   name: "message",
  //   props: route => ({ message: route.query.msg, type: route.query.type })
  // },
  {
    path: "/reset-link",
    name: "reset-password-link",
    component: SendResetPasswordLink,
    meta: {
      auth: true,
      layout: "auth",
    },
  },
  {
    path: "/reset-password",
    name: "reset-password",
    component: ResetPassword,
    meta: {
      auth: true,
      layout: "auth",
    },
  },
  {
    props: true,
    path: "/verification/:id",
    name: "verification",
    component: Verification,
    meta: {
      auth: true,
      layout: "auth",
    },
  },
  {
    name: "logout",
    path: "/logout",
    component: Logout,
    meta: {
      requiresAuth: true,
      layout: "auth",
    },
  },
];
