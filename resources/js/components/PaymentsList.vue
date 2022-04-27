<template>
    <div class="payment-list">

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
                @action="checkAction"
                @copy="copyAddress(item.address)"
                @click="clickPaymentItem(item.id, item.address)"
                @remove="deletePaymentItem(item.id)"
                @edit="showModalEdiPaymentItem(item.id, item.title, item.address, item.holder)"
            />
        </div>
        <div class="fixed-wrapper">
            <transition appear name="fade">
            <div v-if="showMessage" class="message-copy">{{message}}</div>
            </transition>
            <a @click="modalShow" href="#" class="add d-flex align-items-cente justify-content-center">
            Добавить {{checkCrypto ? 'кошелек' : 'карту'}}
            </a>
        </div>

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
            },
            showMessage: false,
            message: ''
        }
    },
    methods: {
        checkAction(data) {
            // this.editShow = false
            // this.editShow = data.action

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
        },
        copyAddress(address) {
            navigator.clipboard.writeText(address)
            .then(() => {
                this.showMessage = true
                this.message = 'Адрес скопирован';
                setTimeout(() => {
                    this.showMessage = false;
                }, 1000);
            })
            .catch(e => {
                console.error(e);
                this.message = 'Что-то пошло не так :( '
                setTimeout(() => {
                    this.showMessage = false;
                }, 1000);
            });
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

.message-copy {
    text-align: center;
    padding: 12px;
    background: #F2F4FA;
    border-radius: 15px;
    position: absolute;
    top: -40px;
    width: 300px;
    left: calc(50% - 150px);
    right: calc(50% - 150px);
}

.payment-list {
    min-height: calc(100vh - 250px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.fixed-wrapper {
    position: sticky;
    bottom: 0px;
    background: linear-gradient(360deg, #FFFFFF 0%, rgba(255, 255, 255, 0.675214) 52.14%, rgba(255, 255, 255, 0) 89.74%);
}
.edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0px;
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

    .add {
        margin-top: 12px;
        color: #0D1F3C;
        font-weight: 600;
        font-size: 16px;
        line-height: 1;
        border-radius: 15px;
        height: 46px;
        border: 2px solid #00aaff;
        align-items: center;
        margin-bottom: 32px;
        background: #fff;
    }
</style>
