<template>
  <v-container>
    <v-container>
      <v-row>
        <v-col cols="1">
          <v-icon class="mr-2 mt-1" @click="toCardSettingsPage()">
            settings
          </v-icon>
        </v-col>
        <v-col cols="4">
          <h2>Баланс</h2>
        </v-col>
        <v-col cols="6">
          <v-btn-toggle
            mandatory
            tile
            color="accent-3"
            v-model="selectedCurrency"
          >
            <v-btn
              elevation="2"
              outlined
              small
              class="mr-2"
              v-for="item in paymentOptions"
              :key="item.id"
            >
              {{ item.currency }}</v-btn
            >
          </v-btn-toggle>
        </v-col>
      </v-row>

      <v-container>
        <v-row>
          <v-col cols="4">
            <h5>{{ feesGained }} {{ selectedCurrencyName }}</h5>
          </v-col>
        </v-row>

        <v-row dense>
          <v-col cols="12">
            <apexchart
              type="bar"
              :options="chartOptions"
              :series="[
                {
                  name: 'Fees Won',
                  data: [feesPercent],
                },
                {
                  name: 'Unlocked Deposit',
                  data: [unlockedDepositPercent],
                },
                {
                  name: 'Locked Deposit',
                  data: [lockedDepositPercent],
                },
              ]"
              height="30px"
            ></apexchart>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="4">
            <h5>{{ availableDeposit }} {{ selectedCurrencyName }}</h5>
          </v-col>
          <v-col cols="4"> </v-col>
          <v-col>
            <h5>{{ lockedDeposit }} {{ selectedCurrencyName }}</h5>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
    <v-list-item>
      <v-tabs v-model="tab" grow>
        <v-tab> Принять </v-tab>
        <v-tab> Отправить </v-tab>
      </v-tabs>
    </v-list-item>
    <v-container style="max-height: 60vh" class="overflow-y-auto">
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-container>
            <RequestTab
              :requestValue="150000"
              :requestCurrency="'RUB'"
              :requestFlow="'in'"
              :time="'15:23'"
              :requestNumber="458821"
              :requestCommisionPercent="15"
              :requestCommissionBonus="1500"
              :requestAcceptedCards="'any'"
              :warnDepositNotEnough="1"
              :requestState="0"
              :key="1"
            />

            <RequestTab
              :requestValue="170000"
              :requestCurrency="'RUB'"
              :requestFlow="'in'"
              :time="'08:11'"
              :requestNumber="458320"
              :requestCommisionPercent="10"
              :requestCommissionBonus="1000"
              :requestAcceptedCards="'any'"
              :warnDepositNotEnough="0"
              :requestState="0"
              :key="2"
            />

            <RequestTab
              :requestValue="90000"
              :requestCurrency="'RUB'"
              :requestFlow="'in'"
              :time="'18:55'"
              :requestNumber="459333"
              :requestCommisionPercent="10"
              :requestCommissionBonus="1000"
              :requestAcceptedCards="'any'"
              :warnDepositNotEnough="0"
              :requestState="0"
              :key="3"
            />
            <RequestTab
              :requestValue="90000"
              :requestCurrency="'RUB'"
              :requestFlow="'in'"
              :time="'18:55'"
              :requestNumber="459333"
              :requestCommisionPercent="10"
              :requestCommissionBonus="1000"
              :requestAcceptedCards="'any'"
              :warnDepositNotEnough="0"
              :requestState="0"
              :key="3"
            />
          </v-container>
        </v-tab-item>

        <v-tab-item>
          <v-container>
            <RequestTab
              :requestValue="50000"
              :requestCurrency="'RUB'"
              :requestFlow="'out'"
              :time="'08:53'"
              :requestNumber="459321"
              :requestCommisionPercent="10"
              :requestCommissionBonus="1000"
              :requestAcceptedCards="'any'"
              :warnDepositNotEnough="0"
              :requestState="0"
            />
          </v-container>
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </v-container>
</template>

<script>
import RequestTab from "../../components/RequestTab";
import VueApexCharts from "vue-apexcharts";

export default {
  data: () => ({
    //deposit/withdraw option selector
    tab: null,

    // 0 - idle, 1 - deposit/withdraw menu, 2 withdrawal confirmation
    screenMode: 0,

    selectedCurrency: 0,

    chartOptions: {
      grid: {
        show: false,
      },
      chart: {
        type: "bar",
        height: 100,
        stacked: true,
        stackType: "100%",
        toolbar: {
          show: false,
        },
        sparkline: {
          enabled: true,
        },
      },
      plotOptions: {
        bar: {
          barHeight: "100%",
          borderRadius: 5,
          horizontal: true,
          startingShape: "rounded",
          endingShape: "rounded",
        },
      },
      stroke: {
        width: 1,
        colors: ["#fff"],
      },
      xaxis: {
        labels: {
          show: false,
        },
        lines: {
          show: false,
        },
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      yaxis: {
        labels: {
          show: false,
        },
        lines: {
          show: false,
        },
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      colors: ["#b2dfdb", "#64dd17", "#ff5252"],

      fill: {
        opacity: 1,
      },
      legend: {
        show: false,
        position: "top",
        horizontalAlign: "left",
      },
    },
  }),
  computed: {
    feesGained() {
      return (
        this.$store.state.deposits[this.selectedCurrency].ballance * 0.1 +
        Math.floor(Math.random() * (60 - 7) + 7)
      );
    },
    availableDeposit() {
      return this.$store.state.deposits[this.selectedCurrency].ballance;
    },
    lockedDeposit() {
      return this.$store.state.deposits[this.selectedCurrency].locked_ballance;
    },
    selectedCurrencyName() {
      return this.$store.state.deposits[this.selectedCurrency].currency;
    },

    paymentOptions() {
      return this.$store.state.paymentOptions;
    },
    feesPercent: function () {
      return Math.floor((this.feesGained / this.totalAmount()) * 100) / 100;
    },
    lockedDepositPercent: function () {
      return Math.floor((this.lockedDeposit / this.totalAmount()) * 100) / 100;
    },
    unlockedDepositPercent: function () {
      return (
        Math.floor((this.availableDeposit / this.totalAmount()) * 100) / 100
      );
    },

  },
  watch: {
    screenMode: function (val) {
      this.$store.commit("SET_NAV_STATE", val);
    },
  },
  methods: {
    totalAmount() {
      return this.feesGained + this.availableDeposit + this.lockedDeposit;
    },
    toCardSettingsPage() {
      this.$router.push({ name: "gate-settings" });
    },
  },
  components: { RequestTab, apexchart: VueApexCharts },
};
</script>

<style>
</style>
