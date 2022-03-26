<template>
    <div>
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
                @remove="deletePaymentItem(item.id)"
                @edit="showModalEdiPaymentItem(item.id, item.title, item.address, item.holder)"
            />
        </div>
        <a @click="modalShow" href="#" class="add-payment_item d-flex align-items-cente justify-content-center">
            <span> Добавить {{checkCrypto ? 'кошелек' : 'карту'}}</span>
        </a>
        <ModalFormAddPaymentItem v-if="showModal" @close="showModal = false" @send="addPaymentItem" :checkCrypto="checkCrypto"/>
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
        order: Object,
        _tocken: String,
        crypto: String
    },
    data() {
        return {
            showModal: false,
            showModalEdit: false,
            items: true,
            checkCrypto: parseInt(this.crypto),
            item: {
                id: '',
                title: '',
                address: '',
                holder: ''
            }
        }
    },
    methods: {
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
        getPaymentItems() {
            axios.get("/api/payment_details/get")
            .then(response => {
                this.items = response.data.filter((item) => item.payment.title == this.order.payment)
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
                _tocken: this._tocken,
                payment: this.order.payment,
                };
                axios.post("/api/payment_details/add", paymentItem)
                .then(response => {
                    this.showModal = false
                    this.getPaymentItems()
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        editPaymentItem(data) {
            const paymentItem = {
                title: data.title,
                holder_name: data.holder ? data.holder : null,
                address: data.address,
                id: this.item.id,
                _tocken: this._tocken,
                payment: this.order.payment,
                };
                axios.post("/api/payment_details/edit", paymentItem)
                .then(response => {
                    this.showModalEdit = false
                    this.getPaymentItems()
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
};
</script>


