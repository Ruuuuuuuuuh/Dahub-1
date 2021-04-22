<template>
  <div>
    <v-navigation-drawer app fixed right width="100%" v-model="showMenu">
      <v-container class="grey lighten-5">
        <v-list-item>
          <v-list-item-content>
            <v-icon
              style="position: absolute; right: 0px"
              @click.stop="toggleMenu"
              >cancel</v-icon
            >
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Заявки</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Депозит</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Настройки</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>История Транзакций</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item v-if="this.$store.state.userMode == 1">
          <v-switch
            v-model="gateOnlineSwitch"
            inset
            :label="`Я сейчас ${gateOnlineSwitch ? 'онлайн' : 'оффлайн'}`"
          ></v-switch>
        </v-list-item>
      </v-container>

      <v-container
        class="grey lighten-5"
        style="position: absolute; bottom: 5%"
      >
        <!-- fill-height -->
        <v-row align="center" justify="space-between">
          <v-btn-toggle v-model="userMode" mandatory group>
            <v-btn width="50%"> <h5>Размещаю заявки</h5> </v-btn>
            <v-btn width="50%"> <h5>Обрабатываю заявки</h5> </v-btn>
          </v-btn-toggle>
        </v-row>
      </v-container>
    </v-navigation-drawer>

    <v-app-bar>
      <v-app-bar-nav-icon v-if="showBackNav" @click="goBackToggle()">
        <v-icon>navigate_before</v-icon>
      </v-app-bar-nav-icon>
      <v-app-bar-nav-icon
        style="position: absolute; right: 10px"
        @click.stop="toggleMenu"
      ></v-app-bar-nav-icon>
    </v-app-bar>
  </div>
</template>

<script>
import EventBus from "../eventbus";

export default {
  name: "TopToolbar",
  data: () => ({
    showMenu: false,
    showBackNav: false,
  }),
  methods: {
    toggleMenu() {
      this.showMenu = !this.showMenu;
    },
    goBackToggle() {
      if (this.$store.state.userMode == 0) {
        this.$router.push({name: "request-main"});
      } else if (this.$store.state.userMode == 1) {
        this.$router.push({name: "gate-main"});
      }
      EventBus.$emit("go_back_action", {});
    },
  },
  watch: {
    $route: function (to) {
      if (to.name == "request-main" || to.name == "gate-main") {
        if (this.$store.state.navState == 0) {
          this.showBackNav = false;
        }
      } else {
        this.showBackNav = true;
      }
    },
    "$store.state.navState": function (val) {
      if (val == 0) {
        if (
          this.$route.name == "request-main" ||
          this.$route.name == "gate-main"
        ) {
          this.showBackNav = false;
        }
      } else {
        this.showBackNav = true;
      }
    },
  },

  computed: {
    userMode: {
      get() {
        return this.$store.state.userMode;
      },
      set(val) {
        this.$store.commit("SET_USER_MODE", val);
        if (val == 0) {
          this.$router.push({ name: "request-main" });
        } else if (val == 1) {
          this.$router.push({ name: "gate-main" });
        }
      },
    },

    gateOnlineSwitch: {
      get() {
        return this.$store.state.gateUser.isOnline;
      },
      set(val) {
        this.$store.commit("SET_GATE_AVAILABILITY", val);
      },
    },
  },
};
</script>

<style scoped>
</style>
