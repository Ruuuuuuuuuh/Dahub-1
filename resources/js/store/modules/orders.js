export default  {
    state:{
        orders: [],

    },
    mutations: {
        getWindowOrders(state, orders) {
            state.orders = orders
        },
    },
    getters: {
        orders(state) {
            return state.orders
        }
    }
}
