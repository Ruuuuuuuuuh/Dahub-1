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
    <div class="form-control amount-wrapper">
        <label for="amount">Сумма</label>
        <div class="select-wrapper">
            <input type="number" name="amount" class="input-amount" placeholder="0" min="0" v-model="amount" @input="checkValidate()"/>
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
    <div class="form-control address">
        <label for="address">{{ this.crypto ? 'Номер кошелька' : 'Номер карты'}}</label>
        <div class="select-wrapper" @click="paymentsDeatails()">
            <a class="addres-btn" href="#">
                <span v-if="!address"> {{ crypto ? 'Выбрать кошелек' : 'Выбрать карту'}} </span>
                    <div v-if="address" class="address-text">
                        <div>
                            {{address}}
                        </div>

                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.50871 15.0002H5.85407C6.10498 15.0002 6.27224 14.9168 6.43951 14.7502L15.6393 5.5835C15.9738 5.25016 15.9738 4.75016 15.6393 4.41683L12.2939 1.0835C11.9594 0.750163 11.4576 0.750163 11.123 1.0835L1.92327 10.2502C1.756 10.4168 1.67236 10.5835 1.67236 10.8335V14.1668C1.67236 14.6668 2.0069 15.0002 2.50871 15.0002ZM3.34488 11.1668L11.7083 2.8335L13.8828 5.00016L5.51937 13.3335H3.34488V11.1668ZM17.5629 19.1667C18.0647 19.1667 18.3992 18.8333 18.3992 18.3333C18.3992 17.8333 18.0647 17.5 17.5629 17.5H2.50871C2.0069 17.5 1.67236 17.8333 1.67236 18.3333C1.67236 18.8333 2.0069 19.1667 2.50871 19.1667H17.5629Z" fill="black"/>
                            <mask id="mask0_1505_9645" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="1" y="0" width="18" height="20">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.50871 15.0002H5.85407C6.10498 15.0002 6.27224 14.9168 6.43951 14.7502L15.6393 5.5835C15.9738 5.25016 15.9738 4.75016 15.6393 4.41683L12.2939 1.0835C11.9594 0.750163 11.4576 0.750163 11.123 1.0835L1.92327 10.2502C1.756 10.4168 1.67236 10.5835 1.67236 10.8335V14.1668C1.67236 14.6668 2.0069 15.0002 2.50871 15.0002ZM3.34488 11.1668L11.7083 2.8335L13.8828 5.00016L5.51937 13.3335H3.34488V11.1668ZM17.5629 19.1667C18.0647 19.1667 18.3992 18.8333 18.3992 18.3333C18.3992 17.8333 18.0647 17.5 17.5629 17.5H2.50871C2.0069 17.5 1.67236 17.8333 1.67236 18.3333C1.67236 18.8333 2.0069 19.1667 2.50871 19.1667H17.5629Z" fill="white"/>
                            </mask>
                            <g mask="url(#mask0_1505_9645)">
                            <rect width="20.0722" height="20" fill="#0D1F3C"/>
                            </g>
                        </svg>
                    </div>
                </a>
            <input type="button" name="address" hidden class="input-address"  v-model="address" @change="checkValidate()"/>
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
import PaymentsList from './PaymentsList.vue'
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
        }
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
    background: linear-gradient(87.76deg, #85F362 -53.4%, #02AAFF 67.87%);
    border-radius: 15px;
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

.address {
    margin-bottom: 0;
}

.addres-btn {
    border-radius: 15px;
    background: #fff;
    height: 46px;
    line-height: 1;
    border: 2px solid #00aaff;
    display: flex;
    color:#0D1F3C;
    font-weight: 600;
    justify-content: center;
    align-items: center;
    padding: 0px 13px;
}

.address-text {
    font-size: 12px;
    display: grid;
    grid-template-columns: 1fr 20px;
    column-gap: 10px;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    overflow: hidden;
    position: relative;
    div {
        display: flex;
        overflow-x: scroll;
        padding-right: 20px;
        }
    &::after {
        content: "";
        position: absolute;
        right: 30px;
        bottom: 0;
        width: 40px;
        height: 18px;
        box-sizing: border-box;
        flex-shrink: 0;
        background: linear-gradient(270deg, #FFFFFF 0%, rgba(255, 255, 255, 0) 100%);
    }
    @media screen and (max-width: 375px) {
        font-size: 10px;
    }
}
</style>
