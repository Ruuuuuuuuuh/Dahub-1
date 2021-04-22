// request user
import RequestMainPage from "./views/requestUser/RequestMainPage.vue";
import RequestCreatePage from "./views/requestUser/RequestCreatePage.vue";
import RequestProcessPage from "./views/requestUser/RequestProcessPage.vue";

// gate user
import GateMainPage from "./views/gateUser/GateMainPage.vue";
import GateSelectDepositCardPage from "./views/gateUser/GateSelectDepositCardPage.vue";
import GateConfirmWithdrawalPage from "./views/gateUser/GateConfirmWithdrawPage.vue";

import RecieveSendTemplate from "./components/RecieveSendTemplate.vue";

import GateAddCard from "./views/gateUser/GateAddCard.vue";

import Home from "./views/Home";
import About from "./views/About";

const routes = [
  {
    path: "/home",
    name: "home",
    component: Home,
  },
  {
    path: "/about",
    name: "about",
    component: About,
  },
//   {
//     path: "/",
//     name: "front",
//     component: RequestMainPage,
//   },
//   {
//     path: "/request-create-page",
//     name: "request-create",
//     component: RequestCreatePage,
//   },
//   {
//     path: "/request-process-page",
//     name: "request-process",
//     component: RequestProcessPage,
//     props: true,
//   },
//   {
//     path: "/gate-main-page",
//     name: "gate-main",
//     component: GateMainPage,
//   },
//   {
//     path: "/gate-settings",
//     name: "gate-settings",
//     component: GateAddCard,
//   },
//   {
//     path: "/gate-select-deposit",
//     name: "gate-select-deposit-card",
//     component: GateSelectDepositCardPage,
//   },
//   {
//     path: "gate-confirm-withdrawal-page",
//     name: "gate-confirm-withdrawal",
//     component: GateConfirmWithdrawalPage,
//   },
//   {
//     path: "/recieve-send-template-page",
//     name: "recieve-send-template",
//     component: RecieveSendTemplate,
//     props: true,
//   },
];

export default routes;
