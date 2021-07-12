import VueRouter, { RouteConfig } from "vue-router";

import Dashboard from './components/Dashboard.vue';

const routes = [
    {
      path: "/dashboard",
      name: "dashboard",
      component: Dashboard
    },

];

const Router = new VueRouter({
    mode: "history",
    routes
  });

export default Router;