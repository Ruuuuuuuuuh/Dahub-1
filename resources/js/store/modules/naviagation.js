export default {
    state: {
        burgerMenu: false
    },
    mutations: {
        changeVisibilityBurgerMenu(state) {
            state.burgerMenu = !state.burgerMenu
        }
    }
}
