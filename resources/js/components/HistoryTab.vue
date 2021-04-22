<template>
  <div>
    <v-row class="justify-center">
      <v-col cols="12">
        <v-card>
          <v-container>
            <v-row dense>
              <v-col cols="6">
                <h5>13 Dec 20 - 12:32</h5>
              </v-col>
              <v-col cols="2" />
              <v-col cols="4">
                <h5>#{{ requestNumber }}</h5>
              </v-col>
            </v-row>
            <v-row dense>
              <v-col cols="11">
                <h5 class="font-weight-light">+ {{ requestValue }} {{ requestCurrency }} - 3000 {{requestCurrency}}</h5>
              </v-col>
            </v-row>
            <v-row dense>
              <v-col cols="8">
                <h5>принять 30000 Р</h5>
              </v-col>
              <v-col cols="4">
                <h5>john3328</h5>
              </v-col>
            </v-row>
          </v-container>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  props: [
    "requestValue",
    "requestCurrency",
    "requestFlow",
    "time",
    "requestNumber",
    "requestCommisionPercent",
    "requestCommissionBonus",
    "requestAcceptedCards",
    "warnDepositNotEnough",
    "requestState",
  ],
  methods: {
    selectCard() {
    },
  },
};
</script>

<style>
</style>
