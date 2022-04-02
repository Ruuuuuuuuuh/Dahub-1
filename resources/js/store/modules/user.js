export default {
    state: {
        user: []
    },
    mutations: {
        getWindowUser(state, user) {
            state.user = user
        }
    },
    getters: {
        getUser(state) {
            return state.user
        }
    }

}
