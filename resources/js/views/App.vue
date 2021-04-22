<template>
  <v-app id="app">
    <TopToolbar></TopToolbar>
    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
import TopToolbar from "../components/TopToolbar.vue";

export default {
  name: "App",
  components: {
    TopToolbar,
  },
};
</script>
