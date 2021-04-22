import axios from "axios";

import Vuex from 'vuex';

export default new Vuex.Store ({
  state: { 
    paymentOptions : [],
    deposits : [],

    // if navState is 0 - there is no route back with the back button
    // this is a small helper variable for now
    navState: 0,

    //0 - request creator
    //1 - gate
    userMode: 0, 
    
    statev2: {

      gateUser: {
        isOnline : false
      },

      requestUser: {
        // Status codes:
        // 0: Gate Awaiting Deposit
        // 1: Gate Received Deposit
        // 2: Payment sent
        createdRequests: [
          {
            requestNumber: 110483,
            type: "depositOnBallance",
            currency: "RUB",
            amount: 3000,
            commissionTotal: 30,
            credentials: {
              userID: 112309,
              bank_name: "TCS Bank",
              holder_name: "Alex Green",
              address: 1233099833227643
            },
            status: 0
          }
        ]
        //   status:
      },

    }
  },
  mutations: {
    //set current mode : 0 - request creator 1 - gate
    SET_USER_MODE (state, newMode){
      state.userMode = newMode;
    },

    // Gate online-offline
    SET_GATE_AVAILABILITY(state, newState){
      state.statev2.gateUser.isOnline = newState;
      console.log('gate available ', state.statev2.gateUser.isOnline)
    },

    // Get payment options
    SET_PAYMENT_OPTIONS (state, paymentOptions){
      state.paymentOptions = paymentOptions;
    },
    // Get deposits
    SET_DEPOSITS (state, deposits){
      state.deposits = deposits
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
    
    SET_NAV_STATE (state, newState){
      state.navState = newState;
      console.log('new nav state ', state.navState)
    }
  },

  //Actions exist to call mutations. 
  //Actions are also responsible in performing 
  //any or all asynchronous calls prior to committing 
  // to mutations. Actions have access to a context object 
  // that provides access to state (with context.state), to 
  // getters (with context.getters), and to the commit function 
  // (with context.commit).

  actions: {
    loadPaymentOptions ({ commit }) {
      axios
        .get('http://localhost:4000/paymentOptions')
        .then(r => r.data)
        .then(assets => {
         commit('SET_PAYMENT_OPTIONS', assets)
        })
    },
    loadDeposits({commit}){
      axios
        .get('http://localhost:4000/deposits')
        .then(r => r.data)
        .then(deposits => {
         commit('SET_DEPOSITS', deposits)
        })
    },
  },
  modules: {},
  
  //Getters are to a Vuex store what computed properties are to a Vue component.
  getters: {
    paymentOptions: state => {
      return state.paymentOptions
    }

  }

});
