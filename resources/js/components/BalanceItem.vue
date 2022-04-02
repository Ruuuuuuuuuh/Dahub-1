<template>
<transition name="fade">
        <div class="balance-item d-flex justify-content-between w-100">
            <div class="balance-item-currency d-flex align-items-center">
                <div class="balance-item-currency-icon">
                    <div class="icon-wrapper" v-html="icon">

                    </div>
                </div>
                <div class="balance-item-currency-text">
                    <div class="balance-item-currency-title" >
                        {{title}}
                    </div>
                    <div class="balance-item-currency-description">
                        {{description}}
                    </div>
                </div>
            </div>
            <div class="balance-item-amount">
                <div class="balance-item-amount-title">
                    {{balance}}
                </div>
                <div class="balance-item-amount-description">
                    $ 00
                </div>
            </div>
        </div>
</transition>
</template>

<script>
export default {
    props: {
        icon: {
            type: String,
            require: true
        },
        title: {
            type: String,
            require: true
        },
        description: {
            type: String,
            require: true
        },
        balance: {
            type: String,
            require: true
        },
    }
}
</script>

<style lang="scss" scoped>
    .balance-item {
        font-weight: 600;
        font-size: 16px;
        line-height: 11px;
        color: #FFFFFF;
        margin: 15px 0;
        display: flex;
        align-items: center;
    }
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .3s cubic-bezier(0.76, 0, 0.24, 1);
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
