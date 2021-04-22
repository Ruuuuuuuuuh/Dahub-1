<template>
  <v-container style="">
    <v-list-item>
      <v-list-item-content>
        <h2>
          Принять {{ amount }}
          {{ currency }}
        </h2>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-subheader class="pl-0"> Статус заявки </v-subheader>
        <v-stepper v-model="statusStep">
          <v-stepper-header>
            <v-stepper-step :complete="statusStep > -1" step="1">
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
              :complete="statusStep > 0"
              step="2"
            ></v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
              :complete="statusStep > 1"
              step="3"
            ></v-stepper-step>
          </v-stepper-header>
        </v-stepper>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content>
        <h3 v-if="statusStep == 0">{{ statusOutput[0] }}</h3>
        <h3 v-if="statusStep == 1">
          {{ amount }} {{ currency }} {{ statusOutput[1] }}
        </h3>
        <h3 v-if="statusStep == 2">
          + {{ amount }} {{ currency }} {{ statusOutput[2] }}
        </h3>
      </v-list-item-content>
    </v-list-item>
    <v-list-item />

    <v-list-item>
      <v-tabs v-model="tab" background-color="transparent" grow>
        <v-tab v-if="statusStep < 2"> Реквизиты </v-tab>
        <!-- <v-tab v-if="statusStep == 2"> Отзыв </v-tab> -->
        <!-- <v-tab> Чат с дропом </v-tab> -->
      </v-tabs>
    </v-list-item>

    <v-container>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat v-if="statusStep < 2">
            <p class="font-weight-light">
              Сообщите клиенту реквизиты,<br />по которым он должен сделать
              перевод
            </p>
            <v-list-item>
              <h4>{{ gateCredentials.bank_name }}</h4>
              <v-btn class="ma-2" text icon color="lighten-2">
                <v-icon>content_copy</v-icon>
              </v-btn>
            </v-list-item>
            <v-list-item>
              <h4>{{ gateCredentials.holder_name }}</h4>
              <v-btn class="ma-2" text icon color="lighten-2">
                <v-icon>content_copy</v-icon>
              </v-btn>
            </v-list-item>
            <v-list-item>
              <h4>{{ gateCredentials.address }}</h4>
              <v-btn class="ma-2" text icon color="lighten-2">
                <v-icon>content_copy</v-icon>
              </v-btn>
            </v-list-item>
          </v-card>

          <v-card flat v-if="statusStep == 2">
            <!-- V1 not needed -->

            <!-- <v-list-item>
                <v-icon>person</v-icon>
                <h3>Silverhand0021</h3>
              </v-list-item>
              <v-list-item>
                <v-rating
                  v-model="rating"
                  color="yellow darken-3"
                  background-color="grey darken-1"
                  empty-icon="$ratingFull"
                  half-increments
                  hover
                ></v-rating>
              </v-list-item>
              <v-list-item />
              <v-list-item>
                <v-textarea
                  label="Оставьте отзыв"
                  auto-grow
                  outlined
                  rows="1"
                  row-height="15"
                ></v-textarea>
              </v-list-item> -->
            <v-list-item></v-list-item>

            <v-list-item>
              <v-btn
                to="/request/main"
                style="
                  position: absolute;
                  bottom: 2rem;
                  margin-left: auto;
                  margin-right: auto;
                  left: 0;
                  right: 0;
                  width: 90%;
                "
                >Закрыть заявку</v-btn
              >
            </v-list-item>
          </v-card>
        </v-tab-item>

        <!-- Chat option goes here -->
        <!-- <v-tab-item>
          <v-card flat>
            <v-card-text>text two!</v-card-text>
          </v-card>
        </v-tab-item> -->
      </v-tabs-items>
    </v-container>

    <v-btn depressed @click="handleNextStep"> DEBUG </v-btn>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    tab: null,
    // statusStep: 0,
    statusOutput: [
      "Заявка принята шлюзом, он ждет перевода",
      "переведены шлюзу",
      "к баллансу",
    ],
  }),
  props: ["requestValue", "requestCurrency", "requestNumber"],

  //vuex shortcuts
  computed: {
    gateCredentials() {
      return this.$store.state.requestUser.createdRequests[0].gateCredentials;
    },
    amount() {
      return this.$store.state.requestUser.createdRequests[0].amount;
    },
    currency() {
      return this.$store.state.requestUser.createdRequests[0].currency;
    },
    statusStep() {
      return this.$store.state.requestUser.createdRequests[0].status;
    },
  },
  methods: {
    handleNextStep: function () {
      this.$store.commit("UPDATE_REQUEST_STATE");
    },
  },
};
</script>

<style>
</style>
