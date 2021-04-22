<template>
  <v-container fluid style="position: relative; width: 90%; height: 95%">
    <div>
      <v-list>
        <v-list-item>
          <v-row>
            <v-col cols="3">
              <h4>{{ this.$route.params.time }}</h4>
            </v-col>
            <v-col cols="4">
              <h4>#{{ this.$route.params.id }}</h4>
            </v-col>
            <v-col cols="3">
              <button @click="setOrderState(2)">debug</button>
            </v-col>
          </v-row>
        </v-list-item>

        <v-list-item>
          <v-row>
            <v-col cols="3">
              <h3>Принять</h3>
            </v-col>
            <v-col cols="9">
              <h3>
                {{ this.$route.params.recieveAmount }}
                {{ this.$route.params.paymentCurrency }}
              </h3>
            </v-col>
          </v-row>
        </v-list-item>
        <v-list-item dense>
          <v-row>
            <v-col>
              <h5>{{ this.$route.params.requiredCard }}</h5>
            </v-col>
          </v-row>
        </v-list-item>
      </v-list>
    </div>

    <div>
      <v-container>
        <v-row>
          <v-col>
            <h3>На что принимаем?</h3>
          </v-col>
        </v-row>
        <v-row>
          <v-container>
            <v-btn-toggle
              v-model="selectedPaymentOption"
              mandatory
              tile
              color="accent-3"
            >
              <v-btn
                v-for="item in this.$store.state.paymentOptions"
                :key="item.id"
                elevation="2"
                outlined
                small
                class="mr-2"
              >
                {{ item.shortName }}</v-btn
              >
            </v-btn-toggle>
          </v-container>
        </v-row>

        <v-row>
          <v-col></v-col>
        </v-row>

        <v-tabs-items v-model="selectedPaymentOption">
          <v-tab-item v-for="item in this.$store.state.paymentOptions" :key="item.id">
            <v-row justify="center">
              <v-col cols="10">
                <cardFrontFace
                  :cardholder_number="item.card_number"
                  :card_provider="item.name"
                  :card_type="item.card_type"
                  :cardholder_name="item.cardholder_name"
                >
                </cardFrontFace>
              </v-col>
            </v-row>
          </v-tab-item>
        </v-tabs-items>
      </v-container>

      <v-container
        style="
          position: absolute;
          bottom: 0;
          margin-left: auto;
          margin-right: auto;
          left: 0;
          right: 0;
        "
      >
        <template v-if="orderState === 0">
          <v-list-item>
            <v-btn block depressed @click="setOrderState(1)" color="primary">
              Участвовать
            </v-btn>
          </v-list-item>
        </template>

        <template v-if="orderState === 1">
          <v-layout justify-center>
            <v-list>
              <v-list-item>
                <v-btn color="error" plain align="center"> Отказаться </v-btn>
              </v-list-item>
              <v-list-item>
                <p>Заявка принята, ждем кого выберут...</p>
              </v-list-item>
              <v-list-item>
                <v-btn block depressed disabled color="primary">
                  Участвовать
                </v-btn>
              </v-list-item>
            </v-list>
          </v-layout>
        </template>

        <template v-if="orderState === 2">
          <v-list-item>
            <p>Поздравляем!!!</p>
          </v-list-item>
          <v-list-item>
            <p>Вас выбрали исполнителем!</p>
          </v-list-item>
          <v-list-item>
            <v-btn
              block
              depressed
              color="primary"
              @click="toRecieveProcessPage()"
            >
              Принять заявку
            </v-btn>
          </v-list-item>
        </template>
      </v-container>
    </div>
  </v-container>
</template>

<script>
import cardFrontFace from "../../components/cardFrontFace.vue";

export default {
  // props:['cid', 'ttime'],
  // props:['time', 'orderNumber', 'recieveAmount', 'cardType']
  components: { cardFrontFace },

  data: () => ({
    orderState: 0,
    // 0 - observing, 1 - request to participate,  2 - selected to participate
    selectedPaymentOption: 0,
  }),
  methods: {
    setOrderState(newState) {
      this.orderState = newState;
    },
    toRecieveProcessPage() {
      this.$router.push({
        name: "recieve-send-template",
        params: {
          requestValue: this.$route.params.recieveAmount,
          requestCurrency: this.$route.params.paymentCurrency,
          requestFlow: "in",
          requestNumber: 122334,
          time: "14:03",
          requestCommisionPercent: 0,
          requestCommissionBonus: 0,
          requestState: 0,
          card: this.$store.state.paymentOptions[this.selectedPaymentOption],
        },
      });
    },
  },
};
</script>

<style>
</style>
