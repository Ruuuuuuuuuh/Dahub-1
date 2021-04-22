<template>
  <v-card
    elevation="2"
    outlined
    color="grey"
    class="mx-auto"
    @click="selectRequest()"
  >
    <v-row>
      <v-col cols="5" class="ml-2">
        <h5 class="font-weight-light">#{{ request_number }}</h5>
      </v-col>
      <v-col cols="7">
        <h5 class="font-weight-light">{{ request_date }} - {{ request_time }}</h5>
      </v-col>
    </v-row>
    <v-row dense>
      <v-col cols="12" class="ml-2"
        ><h4 class="font-weight-regular">Принять {{ request_amount }} {{ request_currency }}</h4></v-col
      >
    </v-row>
    <v-row>
      <v-col cols="12"> <h5 class="font-weight-light"> {{ request_status }} </h5></v-col>
    </v-row>
  </v-card>
</template>

<script>
export default {
  props: [
    "request_number",
    "request_date",
    "request_time",
    "request_status",
    "request_amount",
    "request_currency",
    "request_type",
  ],
  methods: {
    selectRequest() {
      this.$router.push({
        name: "request-process",
      });
    },
  },
};
</script>

<style>
</style>