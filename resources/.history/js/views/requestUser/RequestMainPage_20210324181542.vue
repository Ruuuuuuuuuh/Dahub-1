<template>
  <v-container fluid style="width: 90%; height: 90%">
    <v-container class="fullwidth">
      <v-list-item dense>
        <v-btn-toggle
          v-model="selected_payment"
          mandatory
          tile
          color="accent-3"
        >
          <v-btn
            v-for="item in assets"
            :key="item.ix"
            elevation="2"
            outlined
            small
            class="mr-2"
          >
            {{ item.currency }}</v-btn
          >
        </v-btn-toggle>
      </v-list-item>

      <v-list-item dense>
        <v-row v-if="assets != null">
          <v-col cols="3">
            <overline>Баланс</overline>
          </v-col>
          <v-col v-if="assets[selected_payment].recentBallanceChange != null">
            <overline v-if="assets[selected_payment].recentBallanceChange.way === 'increase'">
              + {{ assets[selected_payment].recentBallanceChange.value }}
            </overline>
            <overline v-if="assets[selected_payment].recentBallanceChange.way === 'decrease'">
              - {{ assets[selected_payment].recentBallanceChange.value }}
            </overline>
            <overline>{{ assets[selected_payment].currency }}</overline>
          </v-col>
        </v-row>
      </v-list-item>

      <v-list-item dense>
        <h2 class="font-weight-regular">
          {{ assets[selected_payment].ballance }}
        </h2>
        <h2 class="ml-2 font-weight-regular">
          {{ assets[selected_payment].currency }}
        </h2>
        <v-icon
          v-show="screenMode == 0"
          class="ml-3"
          @click="settingsScreenShow()"
          >settings</v-icon
        >
      </v-list-item>
    </v-container>

    <v-container v-if="screenMode === 1">
      <v-row class="justify-space-between" dense>
        <v-btn @click="sendToRequest()" color="blue" small plain>
          Пополнить
        </v-btn>
        <v-btn @click="withdrawScreenShow()" color="blue" small plain>
          Вывести
        </v-btn>
      </v-row>
      <v-row class="pa-2">
        <v-col>
          <h5>История транзакций</h5>
        </v-col>
      </v-row>

      <v-container>
        <HistoryTab
          v-for="(item, ix) in historyData"
          :key="ix"
          :requestValue="item.requestValue"
          :requestCurrency="item.requestCurrency"
          :requestFlow="item.requestFlow"
          :time="item.time"
          :requestNumber="item.requestNumber"
          :requestCommisionPercent="item.requestCommisionPercent"
          :requestCommissionBonus="item.requestCommissionBonus"
          :requestAcceptedCards="item.requestAcceptedCards"
          :warnDepositNotEnough="item.warnDepositNotEnough"
          :requestState="item.requestState"
        >
        </HistoryTab>
      </v-container>
    </v-container>
    <v-container v-if="screenMode === 2">
      <v-container dense class="py-0">
        <v-row>
          <v-col>
            <h3 class="mt-1">Вывести</h3>
          </v-col>
          <v-col>
            <v-switch
              v-model="withdrawToMyCard"
              :label="'Моя карта'"
              class="my-0"
              dense
            ></v-switch>
          </v-col>
        </v-row>
      </v-container>
      <v-list dense>
        <v-list-item>
          <v-list-item-content>
            <v-subheader class="pl-0"> Сумма </v-subheader>
            <v-text-field
              v-model="amountToWithdraw"
              outlined
              dense
              type="number"
            ></v-text-field>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-row>
            <v-col cols="9">
              <v-slider
                v-model="percentToWithdraw"
                inverse-label
                min="0"
                max="100"
              ></v-slider>
            </v-col>
            <v-col cols="3">
              <h3>{{ percentToWithdraw }} %</h3>
            </v-col>
          </v-row>
        </v-list-item>

        <v-container>
          <v-row>
            <v-col cols="4">
              <h5 class="pl-0">Карта</h5>
            </v-col>
          </v-row>
        </v-container>

        <div>
          <!-- if withdraw to mycard -->

          <v-list-item v-if="withdrawToMyCard" class="mx-auto">
            <v-btn-toggle
              v-model="selected_payment"
              mandatory
              tile
              color="accent-3"
            >
              <v-btn
                v-for="item in myCards"
                :key="item.id"
                elevation="2"
                outlined
                small
                class="mr-4"
              >
                {{ item.shortName }}</v-btn
              >
            </v-btn-toggle>
          </v-list-item>

          <!-- Else withdraw to another card -->
          <v-list-item v-else-if="!withdrawToMyCard">
            <v-list-item-content>
              <v-subheader class="pl-0">Введите номер</v-subheader>
              <v-text-field
                v-model="cardNumberToWithdraw"
                outlined
                dense
                type="number"
              ></v-text-field>
            </v-list-item-content>
          </v-list-item>
        </div>
      </v-list>
    </v-container>

    <!-- action buttons -->
    <v-container v-if="screenMode === 0">
      <div class="actionBottomButtons">
        <v-btn block depressed color="primary" @click="sendToRequest()">
          Создать заявку
        </v-btn>
      </div>
    </v-container>

    <v-container v-if="screenMode === 2">
      <div class="actionBottomButtons">
        <v-btn block depressed color="primary"> Вывести </v-btn>
      </div>
    </v-container>
  </v-container>
</template>

<script>
import HistoryTab from "@/components/HistoryTab.vue";
import  EventBus  from "@/eventbus";
export default {
  components: { HistoryTab },
  data: () => ({
    selected_payment: 0,
    historyData: null,
    // 0 - idle, 1 - deposit/withdraw menu, 2 withdrawal confirmation
    screenMode: 0,
    withdrawToMyCard: true,
    amountToWithdraw: null,
    percentToWithdraw: 0,
    cardNumberToWithdraw: "",

  }),
  methods: {
    sendToRequest() {
      this.$router.push({
        name: "request-create",
        params: { currency: this.assets[this.selected_payment].currency },
      });
    },

    settingsScreenShow(){
      if (this.screenMode === 0) {
        this.screenMode = 1;
      }
    },
    withdrawScreenShow() {
      if (this.screenMode === 1) {
        this.screenMode = 2;
      }
    },

    populateData() {
      this.historyData = [
        {
          requestValue: 120000,
          requestCurrency: "RUB",
          requestFlow: "in",
          time: "15:41",
          requestNumber: 667811,
          requestCommisionPercent: 12,
          requestCommissionBonus: 0,
          requestAcceptedCards: "any",
          warnDepositNotEnough: false,
          requestState: 3,
        },

        {
          requestValue: 50000,
          requestCurrency: "RUB",
          requestFlow: "in",
          time: "12:05",
          requestNumber: 640411,
          requestCommisionPercent: 5,
          requestCommissionBonus: 0,
          requestAcceptedCards: "any",
          warnDepositNotEnough: false,
          requestState: 3,
        },

        {
          requestValue: 20000,
          requestCurrency: "RUB",
          requestFlow: "out",
          time: "10:56",
          requestNumber: 63001,
          requestCommisionPercent: 5,
          requestCommissionBonus: 0,
          requestAcceptedCards: "any",
          warnDepositNotEnough: false,
          requestState: 3,
        },
      ]; 
    },
  },

  created() {
    this.populateData();

    this.$store.dispatch('loadPaymentOptions');
    this.$store.dispatch('loadDeposits');
  },

  mounted() {
    EventBus.$on("go_back_action", () => {
      if (this.screenMode > 0) {
        this.screenMode = this.screenMode - 1;
      }
    });

    
  },
  computed :{
    myCards () {
      //TODO
      console.log('NEW CARD MIGHT BE ADDED ', this.$store.state.paymentOptions)
      return this.$store.state.paymentOptions;
    },
    assets() {
      return this.$store.state.deposits;
    }
  },

  watch: {
    amountToWithdraw: function (val) {
      this.percentToWithdraw =
        (val / this.assets[this.selected_payment].ballance) * 100;
    },
    percentToWithdraw: function (newval, oldval) {
      let currAmm =
        (newval / 100) * this.assets[this.selected_payment].ballance;
      if (currAmm >= 1) {
        this.amountToWithdraw = currAmm;
      }
    },
    screenMode : function(val) {
      this.$store.commit('SET_NAV_STATE', val)
    }
  },
};
</script>

<style>
.actionBottomButtons {
  position: absolute;
  bottom: 2rem;
  margin-left: auto;
  margin-right: auto;
  left: 0;
  right: 0;
  width: 90%;
}
</style>
