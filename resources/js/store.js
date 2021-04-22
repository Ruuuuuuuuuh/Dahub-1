import axios from "axios";

const db = require("./data/db.json");

const vuexStore = {
  state: {
    paymentOptions: [{ req: 0 }],
    deposits: [],

    // if navState is 0 - there is no route back with the back button
    // this is a small helper variable for now
    navState: 0,

    //0 - request creator
    //1 - gate
    userMode: 0,

    gateUser: {
      isOnline: false,
    },

    requestUser: {
      createdRequests: [],
    },
  },

  mutations: {
    //set current mode : 0 - request creator 1 - gate
    SET_USER_MODE(state, newMode) {
      state.userMode = newMode;
    },

    // Gate online-offline
    SET_GATE_AVAILABILITY(state, newState) {
      state.gateUser.isOnline = newState;
    },

    // Get payment options
    SET_PAYMENT_OPTIONS(state, paymentOptions) {
      state.paymentOptions = paymentOptions;
    },
    // Get deposits
    SET_DEPOSITS(state, deposits) {
      state.deposits = deposits;
    },
    // Add payment option
    addPaymentOption(state, newCard) {
      state.paymentOptions.push({
        id: newCard.id,
        card_type: "Test",
        currency: newCard.currency,
        cardholder_name: newCard.cardholder_name,
        card_number: newCard.card_number,
        name: "Test Bank Name",
        shortName: "TBN 3333",
        vendor: "Test Vendor",
      });
    },
    // Edit payment option
    // Remove payment option

    SET_NAV_STATE(state, newState) {
      state.navState = newState;
    },

    //Vuex store not only handles the local data
    //store like it should, it also has all the logic
    //needed to refresh the data store from the back-end.
    ADD_NEW_RECEIVE_REQUEST(state, newRequestData) {
      const dateTimeObj = new Date();
      const date = dateTimeObj.getDate()+'.'+(dateTimeObj.getMonth()+1)+'.'+dateTimeObj.getFullYear();
      const time = dateTimeObj.getHours()+":"+dateTimeObj.getMinutes();
      //api call goes here to get the credentials of the gate
      state.requestUser.createdRequests.push({
        requestNumber: newRequestData.requestNumber,
        currency: newRequestData.requestCurrency,
        amount: newRequestData.requestValue,
        commissionTotal: 30,
        gateCredentials: newRequestData.gateCredentials,
        status: 0,
        requestDate: date,
        requestTime: time,
      });
    },

    UPDATE_REQUEST_STATE(state) {
      // Status codes:
      // 0: Gate Awaiting Deposit
      // 1: Gate Received Deposit
      // 2: Payment sent

      let current_status = state.requestUser.createdRequests[0].status;
      state.requestUser.createdRequests[0].status =
      current_status < 2 ? current_status + 1 : current_status;
    },
  },

  //Actions exist to call mutations.
  //Actions are also responsible in performing
  //any or all ASYNCHRONOUS calls prior to committing to mutations
  actions: {
    loadPaymentOptions({ commit }) {
      //axios call could go here...
      commit("SET_PAYMENT_OPTIONS", db.paymentOptions);
    },
    loadDeposits({ commit }) {
      //axios call could go here...
      commit("SET_DEPOSITS", db.deposits);
    },

    async addNewRecieveRequest({ commit }, payload) {
      //Perform a post request something like that

      // axios.post('/api/createnewrequest', {
      //   creatorID: 1299984,
      //   requestValue: payload.requestValue,
      //   requestCurrency: payload.requestCurrency,
      // })
      // .then(function (response) {
      //   requestCreateServerData.gateCredentials = response.gateCredentials etc...
      // })

      //Emulate a lag
      await new Promise((resolve) => setTimeout(resolve, 3000));

      let requestCreateServerData = {
        gateCredentials: {
          userID: 112309,
          bank_name: "TCS Bank",
          holder_name: "Alex Green",
          address: 1233099833227643,
        },
        requestNumber: 127763,
      };

      //from user params
      requestCreateServerData.requestValue = payload.requestValue;
      requestCreateServerData.requestCurrency = payload.requestCurrency;

      commit("ADD_NEW_RECEIVE_REQUEST", requestCreateServerData);
    },
  },
  modules: {},

  //Getters are to a Vuex store what computed properties are to a Vue component.
  getters: {
    paymentOptions: (state) => {
      return state.paymentOptions;
    },
  },
};

export default vuexStore;
