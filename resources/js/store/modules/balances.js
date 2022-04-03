export default  {
    state:{
        balances: [],
        mainScreenbalances: []
    },
    mutations: {
        getWindowBalances(state, balances) {
            state.balances = balances
        },
        getMainScreenbalances(state, tit) {
            state.mainScreenbalances = tit
        }
    },
    getters: {
        allBalances(state) {
            return state.balances
        },
        visibleBalances(state) {
            return state.balances.filter((item) => item.currency.visible == 1)
        },
        visibleBalancesMain(state) {
            return state.balances.filter((item) => state.mainScreenbalances.includes(item.currency.title))
        }
    }
}
