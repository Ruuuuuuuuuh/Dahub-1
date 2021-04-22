<template>
  <v-container
    style="position: relative; margin: auto; width: 90%; height: 95%"
  >
    <v-list-item>
      <v-list-item-content>
        <h2>Создать Заявку</h2>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content>
        <v-subheader class="pl-0">
          Сумма, {{ this.$route.params.currency }}
        </v-subheader>
        <v-form ref="form" v-model="valid">
          <v-text-field
            outlined
            v-model="amountToTransfer"
            type="number"
            :rules="amountRules"
            required
          ></v-text-field>
        </v-form>
      </v-list-item-content>
    </v-list-item>
    <v-divider />
    <v-list-item>
      <v-list-item-content>
        <v-row>
          <v-col cols="9">
            <v-subheader class="pl-0"> Комиссия до </v-subheader>
            <v-slider
              v-model="serviceFeePercent"
              inverse-label
              min="0"
              max="20"
            ></v-slider>
          </v-col>
          <v-col cols="3" class="d-flex justify-space-around align-center">
            <h3>{{ serviceFeePercent }} %</h3>
          </v-col>
        </v-row>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-row>
        <v-col cols="6">
          <v-text-field
            outlined
            v-model="serviceFeeAmount"
            type="number"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-list-item>
    <v-divider />
    <v-list-item>
      <v-subheader class="pl-0">Заявка</v-subheader>
    </v-list-item>

    <v-list-item dense>
      <h3 class="font-weight-regular">
        принять {{ this.$route.params.currency }} {{ amountToTransfer }}
      </h3>
    </v-list-item>
    <v-list-item dense>
      <h3 class="font-weight-regular">
        комиссия до {{ this.$route.params.currency }} {{ serviceFeeAmount }}
      </h3>
    </v-list-item>

    <v-container style="width: 90%">
      <v-list-item>
        <v-btn
          block
          depressed
          color="primary"
          :loading="createButtonLoading"
          :disabled="!valid"
          @click="createRequest()"
        >
          Создать заявку
        </v-btn>
      </v-list-item>
      <v-list-item
        style="display: flex; justify-content: center; align-items: center"
      >
        <v-btn class="ma-1" color="error" plain to="/request/main">
          Отменить
        </v-btn>
      </v-list-item>
    </v-container>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    amountToTransfer: null,
    serviceFeePercent: 0,
    createButtonLoading: false,
    //for form validation
    valid: false,
    amountRules: [(v) => !!v || "Введите сумму", (v) => v > 1 && v < 100000000],
  }),
  methods: {
    createRequest() {
      this.createButtonLoading = true;
      
      this.$refs.form.validate();

      if (this.valid && this.amountToTransfer !== null) {
        let payload = {
          requestValue: this.amountToTransfer,
          requestCurrency: this.$route.params.currency,
        };

        //wait for promise to resolve == wait for timeout
        this.$store.dispatch("addNewRecieveRequest", payload).then(() => {
          this.$router.push({
            name: "request-process",
          });
        });

        this.createButtonLoading = false;
      }
    },
  },
  computed: {
    serviceFeeAmount: {
      get: function () {
        let percOut = this.amountToTransfer * (this.serviceFeePercent / 100);
        return Math.floor((percOut * 100) / 100);
      },
      set: function (newValue) {
        this.serviceFeePercent = this.amountToTransfer / newValue;
      },
    },
  },
};
</script>

<style>
</style>
