<template>
  <v-container fluid style="width: 90%">
    <v-list-item>
      <v-row>
        <v-col cols="3">
          <h4>{{ this.$route.params.time }}</h4>
        </v-col>
        <v-col cols="4">
          <h4>#{{ this.$route.params.id }}</h4>
        </v-col>
      </v-row>
    </v-list-item>

    <v-list-item>
      <v-row>
        <v-col cols="4">
          <h3>Отправить</h3>
        </v-col>
        <v-col cols="8">
          <h3>
            {{ this.$route.params.recieveAmount }}
            {{ this.$route.params.paymentCurrency }}
          </h3>
        </v-col>
      </v-row>
    </v-list-item>

    <v-list-item>
      <v-row>
        <v-col>
          <h5>{{ this.$route.params.requiredCard }}</h5>
        </v-col>
      </v-row>
    </v-list-item>

    <v-list-item>
      <v-row>
        <v-col>
          <h3>Нужно будет отправить на карту</h3>
        </v-col>
      </v-row>
    </v-list-item>
    <div>
      <v-row>
        <v-col></v-col>
      </v-row>

      <v-row justify="center">
        <v-col cols="10">
          <cardFrontFace
            :cardholder_number="card.card_number"
            :card_provider="card.name"
            :card_type="card.card_type"
            :cardholder_name="card.cardholder_name"
          >
          </cardFrontFace>
        </v-col>
      </v-row>
    </div>

    <v-btn
      depressed
      color="primary"
      style="
        position: absolute;
        bottom: 2rem;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        width: 90%;
      "
      @click="toWithdrawProcessPage()"
    >
      Принять заявку
    </v-btn>
  </v-container>
</template>

<script>
import cardFrontFace from "../../components/cardFrontFace.vue";

export default {
  components: { cardFrontFace },
  props:{
  },
  data: () => ({
    // TODO Pull from a external method via order id
    card :{
      card_number:123212321312333,
      name:"Сбербанк",
      card_type:"Visa",
      cardholder_name:"Anatoliyy Black",
    }
  }),
  methods: {
    toWithdrawProcessPage() {
      this.$router.push({
        name: "recieve-send-template",
        params: {
          requestValue: this.$route.params.recieveAmount,
          requestCurrency: this.$route.params.paymentCurrency,
          requestFlow: "out",
          requestNumber: 122334,
          time: "14:03",
          requestCommisionPercent: 0,
          requestCommissionBonus: 0,
          requestState: 0,
          card: this.card,
        },
      });
    },
  },
};
</script>

<style>
</style>
