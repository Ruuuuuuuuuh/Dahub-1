<template>
  <div>
    <v-row class="justify-center">
      <v-col cols="11">
        <v-card @click="selectCard()">
          <v-container >
            <v-row dense>
              <v-col cols="1">
                <div>
                  <div v-if="requestFlow === 'in'">
                    <v-icon color="#4CAF50">south</v-icon>
                  </div>
                  <div v-else-if="requestFlow === 'out'">
                    <v-icon color="#E57373">north</v-icon>
                  </div>
                </div>
              </v-col>
              <v-col cols="5">
                <h5>+ {{ requestValue }} {{ requestCurrency }}</h5>
              </v-col>
              <v-col cols="3">
                <h5>{{ time }}</h5>
              </v-col>
              <v-col cols="3">
                <h5>#{{ requestNumber }}</h5>
              </v-col>
            </v-row>
            <v-row dense>
              <v-col cols="2"> </v-col>
              <v-col cols="10">
                <v-chip
                  label
                  outlined
                  pill
                  fill
                  style="width: 90%; color: #0d47a1"
                >
                  <v-row>
                    <v-col cols="2">
                      <h4 class="font-weight-light">{{ requestCommisionPercent }}%</h4>
                    </v-col>
                    <v-col cols="4">
                      <h4 class="font-weight-light">+{{ requestCommissionBonus }} R</h4>
                    </v-col>
                    <v-col cols="6">
                      <caption>
                        комиссия
                      </caption>
                    </v-col>
                  </v-row>
                </v-chip>
              </v-col>
            </v-row>
            <v-row dense>
              <!-- <v-col /> -->
              <v-col cols="1">
                <v-icon>credit_card</v-icon>
              </v-col>
              <v-spacer />
              <v-col cols="10">
                <h5>{{ requestAcceptedCards }}</h5>
              </v-col>
            </v-row>

            <v-row v-if="warnDepositNotEnough" style="background-color:black" dense> 
              <v-col cols="1">
                <v-icon color="white" small class="ml-1">lock</v-icon>
              </v-col>
              <v-spacer />
              <v-col cols="10">
                <h5 style="color:white;" class="pt-auto font-weight-thin">Не хватает депозита</h5>
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
      if (this.requestFlow === "in") {
        this.$router.push({
          name: "gate-select-deposit-card",
          params: {
            id: this.requestNumber,
            time: this.time,
            recieveAmount: this.requestValue,
            paymentCurrency: this.requestCurrency,
            requiredCard: this.requestAcceptedCards,
          },
        });

        //push inside the store
        //store updates state of request

      } else if (this.requestFlow === "out") {
        this.$router.push({
          name: "gate-confirm-withdrawal",
          params: {
            id: this.requestNumber,
            time: this.time,
            recieveAmount: this.requestValue,
            paymentCurrency: this.requestCurrency,
            requiredCard: this.requestAcceptedCards,
          },
        });
      }
    },
  },
};
</script>

<style>
</style>
