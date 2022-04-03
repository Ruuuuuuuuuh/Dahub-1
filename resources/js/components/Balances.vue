<template>
    <section class="balance">
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="total-amount">
                        <p class="total-amount-title">0<span>ETH</span></p>
                        <p class="total-currency">≈ $ <span>0</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="balance-items">
            <balance-item
                v-for="item in visibleBalancesMain"
                :key="item.currency.id"
                :title="item.currency.title"
                :description="item.currency.subtitle"
                :icon="item.currency.icon"
                :balance="item.balance"
            />
        </div>
    </section>
</template>

<script>
import balanceItem from "./BalanceItem"
import {mapGetters} from 'vuex'
export default {
    components: {
        balanceItem
    },
    computed:{
        ...mapGetters([
            'visibleBalancesMain'
            ])
    },
};
</script>

<style scoped>

</style>
