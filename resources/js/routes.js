// request user
import RequestMainPage from "./views/requestUser/RequestMainPage.vue";
import RequestCreatePage from "./views/requestUser/RequestCreatePage.vue";
import RequestProcessPage from "./views/requestUser/RequestProcessPage.vue";

// // gate user
import GateMainPage from "./views/gateUser/GateMainPage.vue";
import GateSelectDepositCardPage from "./views/gateUser/GateSelectDepositCardPage.vue";
import GateConfirmWithdrawalPage from "./views/gateUser/GateConfirmWithdrawPage.vue";

import RecieveSendTemplate from "./components/RecieveSendTemplate.vue";

import GateAddCard from "./views/gateUser/GateAddCard.vue";



const routes = [
  {
    path: "/request/main",
    name: "request-main",
    component: RequestMainPage,
  },
  
  {
    path: "/request/create",
    name: "request-create",
    component: RequestCreatePage,
  },
  {
    path: "/request/process",
    name: "request-process",
    component: RequestProcessPage,
    props: true,
  },
  {
    path: "/gate/main",
    name: "gate-main",
    component: GateMainPage,
  },
  {
    path: "/gate/settings",
    name: "gate-settings",
    component: GateAddCard,
  },
  {
    path: "/gate/deposit",
    name: "gate-select-deposit-card",
    component: GateSelectDepositCardPage,
  },
  {
    path: "/gate/confirm",
    name: "gate-confirm-withdrawal",
    component: GateConfirmWithdrawalPage,
  },
  {
    path: "/recieve-send-template-page",
    name: "recieve-send-template",
    component: RecieveSendTemplate,
    props: true,
  },
];

export default routes;
