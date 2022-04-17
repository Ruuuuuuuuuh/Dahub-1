<template>
    <div>
        <div class="edit-header">
            <a href="#" class="edit-btn" :class="editShow ? 'edit-btn_gradient' : '' " @click.prevent="checkShowEdit">Править</a>
            <a href="#" @click.prevent="modalShow">
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" fill="url(#paint0_linear_1227_1058)"/>
                    <path d="M24.3332 17C24.3332 17.55 23.9665 17.9167 23.4165 17.9167H17.9165V23.4167C17.9165 23.9667 17.5498 24.3334 16.9998 24.3334C16.4498 24.3334 16.0832 23.9667 16.0832 23.4167V17.9167H10.5832C10.0332 17.9167 9.6665 17.55 9.6665 17C9.6665 16.45 10.0332 16.0834 10.5832 16.0834H16.0832V10.5834C16.0832 10.0334 16.4498 9.66669 16.9998 9.66669C17.5498 9.66669 17.9165 10.0334 17.9165 10.5834V16.0834H23.4165C23.9665 16.0834 24.3332 16.45 24.3332 17Z" fill="black"/>
                    <mask id="mask0_1227_1058" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="16" height="16">
                    <path d="M24.3332 17C24.3332 17.55 23.9665 17.9167 23.4165 17.9167H17.9165V23.4167C17.9165 23.9667 17.5498 24.3334 16.9998 24.3334C16.4498 24.3334 16.0832 23.9667 16.0832 23.4167V17.9167H10.5832C10.0332 17.9167 9.6665 17.55 9.6665 17C9.6665 16.45 10.0332 16.0834 10.5832 16.0834H16.0832V10.5834C16.0832 10.0334 16.4498 9.66669 16.9998 9.66669C17.5498 9.66669 17.9165 10.0334 17.9165 10.5834V16.0834H23.4165C23.9665 16.0834 24.3332 16.45 24.3332 17Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0_1227_1058)">
                    <rect x="6" y="6" width="22" height="22" fill="white"/>
                    </g>
                    <defs>
                    <linearGradient id="paint0_linear_1227_1058" x1="-43.7143" y1="24.0833" x2="23.9205" y2="18.446" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#85F362"/>
                    <stop offset="1" stop-color="#02AAFF"/>
                    </linearGradient>
                    </defs>
                </svg>
            </a>
        </div>
        <div class="payment-items">
            <PaymentItem
                v-for="item in items"
                :title="item.title"
                :address="item.address"
                :holder="item.holder"
                :data-id="item.id"
                :data-address="item.address"
                :data-title="item.payment.title"
                :payment="item.payment.title"
                :key="item.id"
                :checkCrypto="checkCrypto"
                :editShow="editShow"
                @click="clickPaymentItem(item.id, item.address)"
                @remove="deletePaymentItem(item.id)"
                @edit="showModalEdiPaymentItem(item.id, item.title, item.address, item.holder)"
            />
        </div>
        <!-- <a @click="modalShow" href="#" class="add-payment_item d-flex align-items-cente justify-content-center">
            <span> Добавить {{checkCrypto ? 'кошелек' : 'карту'}}</span>
        </a> -->
        <ModalFormAddPaymentItem v-if="showModal" @close="showModal = false" @send="addPaymentItem" :checkCrypto="checkCrypto" :checkPayment="payment ? true : false"/>
        <ModalFormEditPaymentItem v-if="showModalEdit" @close="showModalEdit = false" @send="editPaymentItem" :checkCrypto="checkCrypto" :vTitle="item.title" :vAddress="item.address" :vHolder="item.holder"/>
    </div>
</template>

<script>
import PaymentItem from "./PaymentItem.vue";
import ModalFormAddPaymentItem from "./ModalFormAddPaymentItem.vue";
import ModalFormEditPaymentItem from "./ModalFormEditPaymentItem.vue";
export default {
    components: {
        PaymentItem,
        ModalFormAddPaymentItem,
        ModalFormEditPaymentItem
    },
    props: {
        payment: String,
        _token: String,
        crypto: ''
    },
    data() {
        return {
            showModal: false,
            showModalEdit: false,
            editShow: false,
            dataPayment: this.payment,
            items: true,
            checkCrypto: parseInt(this.crypto),
            item: {
                id: '',
                title: '',
                address: '',
                holder: '',
                payment: ''
            }
        }
    },
    methods: {
        checkShowEdit() {
            this.editShow = !this.editShow
        },
        modalShow(e) {
            this.showModal = true
        },
        showModalEdiPaymentItem(id, title, address, holder) {
            this.showModalEdit = true
            this.item.id = id
            this.item.title = title
            this.item.address = address
            this.item.holder = holder
        },
        clickPaymentItem(id, address) {
            this.item.id = id
            this.item.address = address
            this.$emit('itemData', this.item)
        },
        getPaymentItems() {
            axios.get("/api/payment_details/get")
            .then(response => {
                if(this.payment) {
                this.items = response.data.filter((item) => item.payment.title == this.payment)
                } else {
                    this.items = response.data.filter((item) => item.payment.crypto == this.checkCrypto)
                }
            })
            .catch((error) => {
                console.log(error.response);
            });

        },
        addPaymentItem(data) {
            const paymentItem = {
                title: data.title,
                holder_name: data.holder ? data.holder : null,
                address: data.address,
                _token: this._token,
                payment: this.payment ? this.payment : data.payment
                };
                axios.post("/api/payment_details/add", paymentItem)
                .then(response => {
                    this.showModal = false
                    this.getPaymentItems()
                })
                .catch((error) => {
                    console.log(error);
                    console.log(this.dataPayment)
                });
        },
        editPaymentItem(data) {
            const paymentItem = {
                title: data.title,
                holder_name: data.holder ? data.holder : null,
                address: data.address,
                id: this.item.id,
                _token: this._token,
                payment: this.item.payment,
                };
                axios.post("/api/payment_details/edit", paymentItem)
                .then(response => {
                    this.showModalEdit = false
                    this.getPaymentItems()
                    document.querySelector('.order-accept').dataset.address = response.data.address
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
        deletePaymentItem(id) {
            let conf = confirm('Точно удалить?')
            if(conf){
                axios.post("/api/payment_details/remove", {id})
                .then(response => {
                    let item = document.querySelector(`.payment-item[data-id="${id}"]`)
                    item.style.transform = 'translateX(-100%)'
                    this.getPaymentItems()
                    document.querySelector('.order-accept').classList.add('disabled') // Обязательно изменить на один общий компонент
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        }
    },
    mounted() {
        this.getPaymentItems()
    },
    watch: {
        payment: function() {
            this.getPaymentItems()
        },
        crypto: function() {
            this.checkCrypto = this.crypto
        }
    }
};
</script>

<style scoped>
    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .edit-btn {
        font-size: 16px;
        padding: 12px 12px 12px 0px;
        font-weight: 500;
        color: #78839C;
    }
    .edit-btn_gradient {
        background: linear-gradient(85.24deg, #85F362 -116.44%, #02AAFF 68.46%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
