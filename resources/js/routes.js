import VueRouter from "vue-router";
import Home from "./screens/Home"
import CreateOrder from "./screens/CreateOrder"
import CreateOrderDeposit from "./screens/CreateOrderDeposit"
import Settings from "./screens/Settings"

export default new VueRouter({
    routes: [
        {
            path: '',
            component: Home,
            name: 'home'
        },
        {
            path: '/create-order',
            component: CreateOrder,
            name: 'create-order',
            children: [
                {
                    path: 'deposit',
                    component: CreateOrderDeposit,
                }
            ]
        },
        {
            path: '/settings',
            component: Settings,
            name: 'settings'
        }
    ],
    // mode: 'history'
})
