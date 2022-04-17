<template>
    <div>
        <ul class="tab-list" role="tablist">
            <li class="tab-list__item" :class="!crypto ? 'tab-list__item-active' : ''">
                <a href="#card" @click.prevent="crypto = 0">Карты</a>
            </li>
            <li class="tab-list__item" :class="crypto ? 'tab-list__item-active' : ''" @click.prevent="crypto = 1">
                <a href="#card">Кошельки</a>
            </li>
        </ul>

        <PaymentsCrypto v-if="crypto === 1" :_token="_token"/>
        <PaymentsFiat v-else  :_token="_token"/>
    </div>
</template>

<script>
import PaymentsCrypto from "../components/PaymentsCrypto.vue";
import PaymentsList from "../components/PaymentsList.vue";
import PaymentsCrypto1 from "../components/PaymentsCrypto.vue";
import PaymentsFiat from "../components/PaymentsFiat.vue";

export default {
    components: { PaymentsCrypto, PaymentsList, PaymentsCrypto1, PaymentsFiat },
    props: {
        _token: String
    },
    data() {
        return {
            crypto: 0,
        }
    }
};
</script>

<style>

.tab-list {
    display: flex;
    justify-content: space-between;
    position: relative;
    list-style: none;
}

.tab-list__item-active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(87.76deg, #85F362 -53.4%, #02AAFF 67.87%);
}

.tab-list__item::before {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: #E6EBF8;
}

.tab-list__item {
    text-align: center;
    padding-bottom: 12px;
    flex-grow: 1;
    position: relative;
}

</style>
