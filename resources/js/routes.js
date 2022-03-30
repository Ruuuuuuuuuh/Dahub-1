import VueRouter from "vue-router";
import Home from "./screens/Home"
import CreateOrder from "./screens/CreateOrder"
import Settings from "./screens/Settings"

export default new VueRouter({
    routes: [
        {
            path: '',
            component: Home
        },
        {
            path: '/create-order',
            component: CreateOrder
        },
        {
            path: '/settings',
            component: Settings
        }
    ],
    // mode: 'history'
})
