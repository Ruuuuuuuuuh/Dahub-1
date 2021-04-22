<template>
  <v-container>
    <v-container>
      <v-row>
        <v-col cols="1"> </v-col>
        <v-col cols="4">
          <h2>Баланс</h2>
        </v-col>
        <v-col cols="6">
          <v-btn-toggle mandatory tile color="accent-3">
            <v-btn
              elevation="2"
              outlined
              small
              class="mr-2"
              v-for="item in this.$store.state.paymentOptions"
              :key="item.id"
            >
              {{ item.currency }}</v-btn
            >
          </v-btn-toggle>
        </v-col>
      </v-row>
    </v-container>

    <v-list-item>
      <v-tabs v-model="tab" background-color="transparent" grow>
        <v-tab> Баланс </v-tab>
        <v-tab> Добавить карту </v-tab>
      </v-tabs>
    </v-list-item>

    <v-container>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-container>
            <!-- <apexchart
              type="bar"
              :options="chartOptions"
              :series="[
                {
                  name: 'Fees Won',
                  data: [12],
                },
                {
                  name: 'Unlocked Deposit',
                  data: [28],
                },
                {
                  name: 'Locked Deposit',
                  data: [60],
                },
              ]"
              height="300px"
            ></apexchart> -->
            <h3>IN PREP</h3>
            <apexchart
              type="bar"
              height="350"
              :options="chartOptions"
              :series="series"
            ></apexchart>
          </v-container>
        </v-tab-item>
        <v-tab-item>
          <v-container>
            <v-form ref="form" v-model="valid">
              <v-list flat>
                <h3 class="font-weight-light">Добавить карту</h3>
                <v-list-item>
                  <v-list-item-content>
                    <v-subheader class="pl-0"> Номер </v-subheader>
                    <v-text-field
                      outlined
                      type="number"
                      v-model="newCard_number"
                      :rules="cardNumberRule"
                      required
                    ></v-text-field>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item dense>
                  <v-list-item-content>
                    <v-row>
                      <v-col cols="8">
                        <v-subheader class="pl-0"> Имя </v-subheader>
                        <v-text-field
                          outlined
                          type="text"
                          dense
                          v-model="cardHolderName"
                          :rules="cardHolderNameRule"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-subheader class="pl-0"> Валюта </v-subheader>
                        <v-select
                          :items="items"
                          dense
                          solo
                          v-model="newCard_currency"
                          :rules="currencySelectedRule"
                          required
                        ></v-select>
                      </v-col>
                    </v-row>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-btn @click="addCardTest()" :disabled="!valid">
                    Добавить карту
                  </v-btn>
                </v-list-item>
              </v-list>
            </v-form>
          </v-container>
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </v-container>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
  data: () => ({
    tab: 0,
    items: ["RUB", "UAH", "USD", "EUR"],
    newCard_number: null,
    cardHolderName: null,
    newCard_currency: null,

    cardNumberRule: [
      (v) => !!v || "Нужен номер",
      (v) => (v && v.length == 16) || "Номер должен состоять из 16 цифр",
    ],
    cardHolderNameRule: [
      (v) => !!v || "Нужно имя",
      (v) => (v && v.length > 7) || "Слишком короткое имя",
      (v) => (v && v.length < 20) || "Слишком длинное имя",
    ],
    currencySelectedRule: [(v) => !!v || "Выберите из списка"],
    valid: false,

    series: [
      {
        name: "Fees won",
        data: [
          {
            x: "A1",
            y: 10,
          },
        ],
      },
      {
        name: "Unlocked deposit",
        data: [
          {
            x: "A1",
            y: 40,
          },
        ],
      },
      {
        name: "Locked Deposit",
        data: [
          {
            x: "A1",
            y: 15,
          },
        ],
      },
    ],

    chartOptions: {
      chart: {
        type: "bar",
        height: 350,
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
          horizontal: false,
          startingShape: "rounded",
          endingShape: "rounded",
        },
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
      
      legend: {
        show: false,
        position: "right",
        offsetY: 40,
      },
      fill: {
        opacity: 1,
      },
    },
  }),
  methods: {
    addCardTest() {
      this.$refs.form.validate();

      this.$store.commit("addPaymentOption", {
        id: 4,
        currency: this.newCard_currency,
        cardholder_name: this.cardHolderName,
        card_number: this.newCard_number,
      });

      this.tab = 0;
      this.newCard_number = null;
      this.cardHolderName = null;
      this.newCard_currency = null;
    },
  },
  components: { apexchart: VueApexCharts },
};
</script>

<style>
</style>