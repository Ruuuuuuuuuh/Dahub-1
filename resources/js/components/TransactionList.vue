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
                <li class="tab-list__item" @click.prevent="setTransfer">
                    <a href="#transfer">Трансфер</a>
                </li>
            </ul>
        </div>
        <div class="transactionList__content">
            <TransactionCell
            v-for="item in filterItem"
            :key="item.id"
            :number="item.number"
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
    data() {
        return {
        transactions: [
            {
                id: 1,
                number: 1,
                destination: 'deposit',
                type: {
                    title: 'Заявка',
                    value: 'order'
                },
                sum: 3123123.3,
                currency: 'USDT',
                date: '24.03.2021 14:20'
            },
            {
                id: 2,
                number: 2,
                destination: 'withdraw',
                type: {
                    title: 'Бонус',
                    value: 'bonus'
                },
                sum: 3123123.3,
                currency: 'DHB',
                date: '30.03.2021 11:20'
            },
            {
                id: 3,
                number: 3,
                destination: 'transfer',
                type: {
                    title: 'Бонус',
                    value: 'bonus'
                },
                sum: 2.3,
                currency: 'BTC',
                date: '30.03.2021 11:20'
            },
        ],
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
        setTransfer(event) {
            this.filterItem = this.transactions.filter( (item) => item.destination == 'transfer')
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

</style>
