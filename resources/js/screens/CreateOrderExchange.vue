<template>
    <div>
        <form class="form-withdraw form-create-order" action="index.html" method="post">
    <input type="hidden" name="destination" value="withdraw"/>
    <div class="form-control">
        <label for="currency">Валюта</label>
        <div class="select-wrapper">
            <select name="currency" class="form-select" v-model="currency" @change="checkCurrency($event)">
                <option  v-for="currency in fillterCurrencies" :key="currency.id" :data-crypto="currency.crypto" :value="currency.title">{{currency.title}}</option>
            </select>
            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                <mask id="angle-down2" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                </mask>
                <g mask="url(#angle-down2)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </div>
    </div>
    <div class="form-control">
        <label for="payment-network">Платёжная система</label>
        <div class="select-wrapper">
            <select name="payment-network" class="form-select select-payment" v-model="selectedPayments" @change="checkPayment()">
                    <option v-for="item in payments" :key="item.id" :value="item.title">{{item.title}}</option>
            </select>
            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                <mask id="angle-down1" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                </mask>
                <g mask="url(#angle-down1)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </div>
    </div>
    <div class="form-control amount-wrapper">
        <label for="amount">Сумма</label>
        <div class="select-wrapper">
            <input type="number" name="amount" class="input-amount" placeholder="0" min="0" v-model="amount" @input="checkValidate()"/>
        </div>
        <label for="amount">Доступно 1 809,98 USDT</label>
    </div>

    <div class="d-flex justify-content-center icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_1336_3694)">
        <path d="M18.5459 22.9082L18.5459 3.72364L22.1382 7.31586C22.5642 7.7419 23.2549 7.7419 23.681 7.31586C24.107 6.8899 24.107 6.19913 23.681 5.7731L18.2264 0.318551C17.8005 -0.107486 17.1097 -0.107486 16.6837 0.318551L11.2291 5.7731C11.0161 5.98611 10.9096 6.26532 10.9096 6.54452C10.9096 6.82372 11.0161 7.10292 11.2291 7.31586C11.6551 7.7419 12.3458 7.7419 12.7719 7.31586L16.3641 3.72364L16.3641 22.9082C16.3641 23.5106 16.8525 23.9991 17.455 23.9991C18.0575 23.9991 18.5459 23.5106 18.5459 22.9082Z" fill="url(#paint0_linear_1336_3694)"/>
        <path d="M12.7713 18.2259C13.1973 17.7999 13.1973 17.1092 12.7713 16.6831C12.3454 16.2571 11.6546 16.2571 11.2286 16.6831L7.63629 20.2754L7.63629 1.09091C7.63629 0.488436 7.14785 7.08692e-08 6.54538 7.80536e-08C5.94291 8.5238e-08 5.45447 0.488436 5.45447 1.09091L5.45447 20.2754L1.86218 16.6832C1.43621 16.2572 0.745449 16.2572 0.319412 16.6832C0.106467 16.8961 -7.89502e-05 17.1753 -7.89468e-05 17.4545C-7.89435e-05 17.7337 0.106467 18.0129 0.319486 18.2259L5.77403 23.6804C6.2 24.1065 6.89076 24.1065 7.3168 23.6804L12.7713 18.2259Z" fill="url(#paint1_linear_1336_3694)"/>
        </g>
        <defs>
        <linearGradient id="paint0_linear_1336_3694" x1="14.7277" y1="-30.8582" x2="21.9061" y2="16.1189" gradientUnits="userSpaceOnUse">
        <stop stop-color="#85F362"/>
        <stop offset="1" stop-color="#02AAFF"/>
        </linearGradient>
        <linearGradient id="paint1_linear_1336_3694" x1="3.8181" y1="-15.6522" x2="4.76569" y2="24.0763" gradientUnits="userSpaceOnUse">
        <stop stop-color="#FF9134"/>
        <stop offset="1" stop-color="#E72269"/>
        </linearGradient>
        <clipPath id="clip0_1336_3694">
        <rect width="24" height="24" fill="white" transform="translate(24) rotate(90)"/>
        </clipPath>
        </defs>
        </svg>
    </div>

    <div class="form-control">
        <label for="currency">Валюта</label>
        <div class="select-wrapper">
            <select name="currency" class="form-select" v-model="currency" @change="checkCurrency($event)">
                <option  v-for="currency in fillterCurrencies" :key="currency.id" :data-crypto="currency.crypto" :value="currency.title">{{currency.title}}</option>
            </select>
            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                <mask id="angle-down2" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                </mask>
                <g mask="url(#angle-down2)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </div>
    </div>
    <div class="form-control amount-wrapper">
        <label for="amount">Сумма к получению</label>
        <div class="select-wrapper">
            <input type="number" readonly name="amount" class="input-amount" placeholder="0" min="0" v-model="amount" @input="checkValidate()"/>
        </div>
        <label for="amount" style="text-align: center;">*по лучшему курсу, за вычетом комиссии</label>
    </div>
    <div class="form-control">
        <label for="payment-network">Платёжная система</label>
        <div class="select-wrapper">
            <select name="payment-network" class="form-select select-payment" v-model="selectedPayments" @change="checkPayment()">
                    <option v-for="item in payments" :key="item.id" :value="item.title">{{item.title}}</option>
            </select>
            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                <mask id="angle-down1" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                </mask>
                <g mask="url(#angle-down1)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </div>
    </div>


    <div class="form-control address">
        <label for="address">{{ this.crypto ? 'Выберите кошелек' : 'Выберите карту'}}</label>
        <div class="select-wrapper" @click="paymentsDeatails()">
            <input type="button" name="address" class="input-address" value="" v-model="address" @change="checkValidate()"/>
        </div>
    </div>
    <div v-if="showPayments" >
<transition appear name="modal">
    <section class="screen opened settings">
        <div class="section-header">
            <div class="top-nav">
                <button @click="paymentsDeatails()" class="back-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="#0D1F3C"></path>
                        <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="white"></path>
                        </mask>
                        <g mask="url(#back-link)">
                            <rect width="24" height="24" fill="#0D1F3C"></rect>
                        </g>
                    </svg>
                </button>
                <h2>Список {{ this.crypto ? 'кошельков' : 'карт'}}</h2>
            </div>
        </div>
        <div class="section-main">
            <payments-list
            :payment="selectedPayments"
            :crypto="crypto"
            @itemData="checkAddress($event)"
            ></payments-list>
        </div>
    </section>
</transition>
    </div>

</form>
<button ref="button" class="button button-blue " disabled @click="createOrder()">Далее</button>
<transition appear name="modal">
<div class="message" v-if="messageError">
    {{messageError}}
</div>
</transition>
    </div>
</template>

<script>
import PaymentsList from '../components/PaymentsList.vue'
export default {
    components: {
        PaymentsList

    },
    props: {
        currencies: Array,
        _token: String
    },
    data() {
        return {
            fillterCurrencies: this.currencies.filter((item) => item.visible == 1 ),
            currenciesPayment: true,
            currency: 'USDT',
            payments: Array,
            selectedPayments: 'TRC20',
            crypto: Number,
            showPayments: false,
            address: '',
            amount: '',
            messageError: ''

        }
    },
    methods: {
        createOrder() {
            let data = {
                "_token": this._token,
                "currency": this.currency,
                "amount": this.amount,
                "payment": this.selectedPayments,
                "address": this.address,
                "destination": 'withdraw'
            }
            axios.post("/api/createOrderByUser", data)
                .then(response => {
                    console.log(response)
                    document.location.href = '/wallet/orders/' + response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.messageError = error.response.data.message
                    // document.location.href = '/wallet/orders/' + data;
                });
        },
        checkAddress(event) {
            this.address = event.address

            this.checkValidate()
            this.paymentsDeatails()
        },
        checkCurrency() {
            this.payments = this.fillterCurrencies.filter((item) => item.title == this.currency)[0].payments
            this.crypto = this.payments[0].crypto
            this.selectedPayments = this.payments[0].title
            this.address = ''
        },
        checkPayment() {
            console.log(this.selectedPayments)
            this.crypto = this.payments[0].crypto
            this.address = ''
            this.checkValidate()
        },
        paymentsDeatails() {
            this.showPayments = !this.showPayments
        },
        checkValidate() {
            if(this.address && this.amount) {
                this.$refs.button.removeAttribute('disabled')
            } else {
                this.$refs.button.setAttribute('disabled', 'disabled')
            }
        }
    },
    created() {
        this.checkCurrency()
    },
    watch: {
        currency() {
            this.checkValidate()
        },

    }
}
</script>

<style lang="scss" scoped>

.modal-enter-active, .modal-leave-active {
    transition: all .2s;
}
.modal-enter, .modal-leave-to {
    transform: translateY(100%);
}

.button {
    background: #347AF0;
    border-radius: 23px;
    width: 100%;
    display: block;
    text-align: center;
    font-weight: 500;
    font-size: 18px;
    line-height: 46px;
    color: #FFFFFF;
    margin-top: 20px;
}

.button[disabled] {
    opacity: .5;
}
.icon {
    margin-bottom: 24px;
}
.message {
    text-align: center;
    padding: 8px;
    background: #fff;
    border: 2px #E15063 solid;
    border-radius: 50px;
    color: #E15063;
    margin-top: 12px;
    font-weight: 600;
}
</style>
