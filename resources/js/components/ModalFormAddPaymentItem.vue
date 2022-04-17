<template>
    <transition appear name="modal-slide">
        <div class="blur">
            <div class="modal-slide">
                <div class="modal-slide__header">
                    <a href="#" class="cancel" @click.prevent="$emit('close')"
                        >Отменить</a
                    >
                </div>
                <div class="modal-slide__content">
                    <h2 class="modal-slide__title">
                        Добавить {{checkCrypto ? 'кошелек': 'карту'}}
                    </h2>
                    <form class="payment-details-form" @submit.prevent="updateFieldValue">

                            <div class="form-group" v-if="!checkCrypto">
                                <input type="text" autocomplete="off" class="form-control" name="holder" v-model="holder" placeholder="Держатель карты*">
                            </div>


                            <div class="form-group" v-if="checkCrypto">
                                <input type="text" autocomplete="off" class="form-control" @input="checkLenghtInput" name="title" v-model="title" :placeholder="checkCrypto ? 'Название кошелька': 'Название карты'">
                            </div>

                        <div class="form-group">
                            <input type="text" autocomplete="off" class="form-control" @input="checkLenghtInput" v-model="address" name="address" :placeholder="checkCrypto ? 'Адрес кошелька*': 'Номер карты*'">
                        </div>
                        <div class="select-wrapper" v-if="!checkPayment">
                            <select class="form-select" v-model="payment" @input="checkLenghtInput" aria-label="Default select example">
                                <option :value="payment.title" v-for="payment in payments" :key="payment.id" >{{payment.title}}</option>
                            </select>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="select-angle"><path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"></path> <mask id="angle-down" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8" style="mask-type: alpha;"><path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"></path></mask> <g mask="url(#angle-down)"><rect width="24" height="24" fill="#0D1F3C"></rect></g></svg>
                        </div>

                        <button ref="button" class="btn btn-primary confirm-modal" disabled >Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        checkCrypto : Number,
        method: Function,
        id: Number,
        checkPayment: Boolean,
    },
    data() {
        return {
            title: '',
            address: '',
            holder: '',

            payment: this.checkCrypto ? 'BEP20 (BSC)' : 'Тинькофф',
            payments: []
        }
    },
    methods: {
        updateFieldValue() {
            this.$emit('send', {
                title: this.title,
                address: this.address,
                holder: this.holder,
                payment: this.payment
                })
        },
        checkLenghtInput(e) {
            if(this.address && this.checkCrypto || this.address && this.holder && !this.checkCrypto) {
                this.$refs.button.removeAttribute('disabled')
            } else {
                this.$refs.button.setAttribute('disabled', 'disabled')
            }
        },
    },
    mounted() {
        this.payments = window.payments.filter((item) => item.crypto == this.checkCrypto)
    }
}

</script>

<style scoped>
button {
    background: linear-gradient(87.76deg, #85F362 -53.4%, #02AAFF 67.87%);
    border-radius: 15px;
    height: 46px;
    border: none;
    font-weight: 600;
    font-size: 18px;
    margin-top: 1rem;
    line-height: 1;
}
.form-select {
    width: 100%;
    height: 46px;
    background: #ffffff;
    border-radius: 15px;
    border: none;
    box-shadow: none;
    font-weight: 600;
    font-size: 14px;
    line-height: 24px;
    color: #0D1F3C;
    padding: 0 25px;
}
.modal-enter-active, .modal-leave-active {
    transition: opacity .5s;
}
.modal-enter, .modal-leave-to {
    opacity: 0;
}
</style>
