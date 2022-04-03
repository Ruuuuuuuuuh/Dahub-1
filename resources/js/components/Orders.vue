<template>
    <div class="main-screen-wrapper">
        <div class="filter d-flex justify-content-between">
            <div class="filter-items">
                <a class="filter-item active" data-filter="all">Все</a>
                <a class="filter-item" data-filter="deposit">Ввод</a>
                <a class="filter-item" data-filter="withdraw">Вывод</a>
                <a class="filter-item" data-filter="exchange">Конвертация</a>
            </div>
            <div class="filter-action">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.009 2C22.409 2 22.709 2.2 22.909 2.6C23.109 2.9 23.009 3.3 22.809 3.6L15.009 12.8V21C15.009 21.4 14.809 21.7 14.509 21.9C14.409 22 14.209 22 14.009 22C13.809 22 13.709 22 13.609 21.9L9.60902 19.9C9.20902 19.7 9.00902 19.4 9.00902 19V12.8L1.20902 3.6C1.00902 3.3 0.909017 2.9 1.10902 2.6C1.30902 2.2 1.60902 2 2.00902 2H22.009ZM13.009 12.5C13.009 12.2 13.109 12 13.209 11.8L19.909 4H4.20902L10.809 11.9C10.909 12 11.009 12.3 11.009 12.5V18.4L13.009 19.4V12.5Z" fill="black"/>
                    <mask id="mask-filter" mask-type="alpha" maskUnits="userSpaceOnUse" x="1" y="2" width="23" height="20">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.009 2C22.409 2 22.709 2.2 22.909 2.6C23.109 2.9 23.009 3.3 22.809 3.6L15.009 12.8V21C15.009 21.4 14.809 21.7 14.509 21.9C14.409 22 14.209 22 14.009 22C13.809 22 13.709 22 13.609 21.9L9.60902 19.9C9.20902 19.7 9.00902 19.4 9.00902 19V12.8L1.20902 3.6C1.00902 3.3 0.909017 2.9 1.10902 2.6C1.30902 2.2 1.60902 2 2.00902 2H22.009ZM13.009 12.5C13.009 12.2 13.109 12 13.209 11.8L19.909 4H4.20902L10.809 11.9C10.909 12 11.009 12.3 11.009 12.5V18.4L13.009 19.4V12.5Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask-filter)">
                        <rect width="24" height="24" fill="#78839C"/>
                    </g>
                </svg>
            </div>
        </div>

        <div class="orders">
            <orders-item v-for="order in orders" :key="order.id">

            </orders-item>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import OrdersItem from './OrdersItem'
export default {
    components: {OrdersItem},
    computed: {
        ...mapGetters(['orders'])
    }
}
</script>

<style lang="scss" scoped>
    .main-screen-wrapper {
        padding: 30px 25px;
        height: 100%;
    }
    .orders {
        height: calc(100% - 60px);
        overflow-y: scroll;
        padding-bottom: 80px;
        padding-top: 10px;
        margin-top: 10px;
    }
</style>
