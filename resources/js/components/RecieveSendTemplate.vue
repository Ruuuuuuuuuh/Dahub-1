<template>
  <v-container style="height:100%">
    <v-list-item dense>
      <v-row>
        <v-col cols="3">
          <h4>{{ time }}</h4>
        </v-col>
        <v-col cols="4">
          <h4>#{{ requestNumber }}</h4>
        </v-col>
      </v-row>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <h2 v-if="requestFlow === 'in'">
          Принять {{ requestValue }} {{ requestCurrency }}
        </h2>
        <h2 v-else-if="requestFlow === 'out'">
          Отправить {{ requestValue }} {{ requestCurrency }}
        </h2>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-subheader v-if="requestFlow === 'in'" class="pl-0"
          >Любая карта</v-subheader
        >
        <v-subheader v-else-if="requestFlow === 'out'" class="pl-0"
          >С Любой карты</v-subheader
        >

        <v-stepper v-model="statusStep">
          <v-stepper-header>
            <v-stepper-step :complete="statusStep > 1" step="1">
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
              :complete="statusStep > 2"
              step="2"
            ></v-stepper-step>
          </v-stepper-header>
        </v-stepper>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content v-if="requestFlow === 'in'">
        <h3 v-if="statusStep == 1">{{ statusOutput[0] }}</h3>
        <h3 v-if="statusStep == 2">
          +{{ requestValue }} {{ requestCurrency }} {{ statusOutput[1] }}
        </h3>
        <h3 v-if="statusStep == 2">
          +{{ requestCommissionBonus }} моя комиссия
        </h3>
      </v-list-item-content>
      <v-list-item-content v-if="requestFlow === 'out'">
        <h3 v-if="statusStep == 1">{{ statusOutput[0] }}</h3>
        <h3 v-if="statusStep == 2">
          -{{ requestValue }} {{ requestCurrency }} {{ statusOutput[1] }}
        </h3>
        <h3 v-if="statusStep == 2">
          депозит +{{ requestValue }} {{ requestCurrency }}
        </h3>
      </v-list-item-content>
    </v-list-item>
    <v-list-item v-if="statusStep === 1">
      <v-btn
        v-if="requestFlow === 'in'"
        block
        depressed
        color="primary"
        @click="paymentRecievedAction()"
      >
        Перевод получен
      </v-btn>
      <v-btn
        v-else-if="requestFlow === 'out'"
        block
        depressed
        color="primary"
        @click="paymentRecievedAction()"
      >
        Деньги отправлены
      </v-btn>
    </v-list-item>

    <v-list-item class="mt-3">
      <v-tabs v-model="tab" background-color="transparent" grow>
        <v-tab v-if="statusStep < 2"> Реквизиты </v-tab>
        <v-tab v-if="statusStep == 2"> Отзыв </v-tab>
      </v-tabs>
    </v-list-item>

    <v-container>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat v-if="statusStep === 1">
            <v-row justify="center">
              <v-col cols="10">
                <cardFrontFace
                  :cardholder_number="card.card_number"
                  :card_provider="card.name"
                  :card_type="card.card_type"
                  :cardholder_name="card.cardholder_name"
                />
              </v-col>
            </v-row>
          </v-card>
          <v-card flat v-else-if="statusStep === 2">
            <v-card-text>Rating goes here</v-card-text>
          </v-card>
        </v-tab-item>

        <v-tab-item>
          <v-card flat>
            <v-card-text>Chat goes here</v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-container>

    <v-btn
      v-if="statusStep === 2"
      depressed
      color="primary"
      style="
          position: absolute;
          bottom: 2rem;
          margin-left: auto;
          margin-right: auto;
          left: 0;
          right: 0;
          width: 90%;"
      to="/gate/main"
    >
      Закрыть заявку
    </v-btn>
  </v-container>
</template>

<script>
import cardFrontFace from "../components/cardFrontFace.vue";

export default {
  props: {
    requestValue: Number,
    requestCurrency: String,
    requestFlow: String,
    requestNumber: Number,
    time: String,
    requestCommisionPercent: Number,
    requestCommissionBonus: Number,
    requestState: Number,
    card: Object,
  },

  components: { cardFrontFace },

  data: () => ({
    orderState: 0,
    // 0 - observing, 1 - request to participate,  2 - selected to participate

    tab: null,
    statusStep: 1,
    statusOutput: null,
  }),
  created() {
    if (this.requestFlow === "in") {
      this.statusOutput = ["Жду перевода денег", "принято", "моя комиссия"];
    } else {
      this.statusOutput = ["Ждем вашего перевода", "отправлено", "депозит"];
    }
  },
  methods: {
    setOrderState(newState) {
      this.orderState = newState;
    },
    paymentRecievedAction() {
      this.statusStep =
        this.statusStep < 2 ? this.statusStep + 1 : this.statusStep;
    },
  },
};
</script>

<style>
</style>
