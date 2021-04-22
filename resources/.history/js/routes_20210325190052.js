
// request user
import RequestMainPage from "../views/requestUser/RequestMainPage.vue";
import RequestCreatePage from "../views/requestUser/RequestCreatePage.vue";
import RequestProcessPage from "../views/requestUser/RequestProcessPage.vue";

// gate user
import GateMainPage from "../views/gateUser/GateMainPage.vue";
import GateSelectDepositCardPage from "../views/gateUser/GateSelectDepositCardPage.vue";
import GateConfirmWithdrawalPage from "../views/gateUser/GateConfirmWithdrawPage.vue";

import RecieveSendTemplate from '../components/RecieveSendTemplate.vue'

import GateAddCard from '../views/gateUser/GateAddCard.vue'


const routes = [
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
],


export default routes;