<template>
    <div class="transactionList">
        <div class="transactionList__header">
            <ul class="tab-list" role="tablist" ref="tabs">
                <li class="tab-list__item tab-list__item-active" @click.prevent="setAll">
                    <a href="#all">Все</a>
                </li>
                <li class="tab-list__item" @click.prevent="setDeposit">
                    <a href="#deposit">Получение</a>
                </li>
                <li class="tab-list__item" @click.prevent="setWithdraw">
                    <a href="#withdraw">Отправление</a>
                </li>
            </ul>
        </div>
        <div class="transactionList__content">
            <TransactionCell
            v-for="item in filterItem"
            :key="item.id"
            :type="item.type.title"
            :sum="item.sum"
            :currency="item.currency"
            :date="item.date"
            :destination="item.destination"
            />
        </div>
    </div>
</template>

<script>
import TransactionCell from "./TransactionCell.vue";
export default {
    components: { TransactionCell },
    props: ['transactions'],
    data() {
        return {
        transactions: this.transactions,
        filterItem: ''
        }
    },
    methods: {
        setDeposit(event) {
            this.filterItem = this.transactions.filter( (item) => item.destination == 'deposit')
            this.$refs.tabs.querySelector('.tab-list__item-active').classList.remove('tab-list__item-active')
            event.target.classList.add('tab-list__item-active')
        },
        setWithdraw(event) {
            this.filterItem = this.transactions.filter( (item) => item.destination == 'withdraw')
            this.$refs.tabs.querySelector('.tab-list__item-active').classList.remove('tab-list__item-active')
            event.target.classList.add('tab-list__item-active')
        },
        setAll(event) {
            this.filterItem = this.transactions
            this.$refs.tabs.querySelector('.tab-list__item-active').classList.remove('tab-list__item-active')
            event.target.classList.add('tab-list__item-active')

        },
    },
    mounted() {
        this.filterItem = this.transactions
    }
}
</script>

<style>
 .transactionList {
     margin-top:15px;
 }
</style>
