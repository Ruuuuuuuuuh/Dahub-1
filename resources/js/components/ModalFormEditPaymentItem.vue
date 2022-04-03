<template>
<transition appear name="modal">
<div>
    <div class="modal" style="display:block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    <button type="button" class="close" @click="$emit('close')" aria-label="Close">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2.82812" width="40" height="4" rx="2" transform="rotate(45 2.82812 0)" fill="white"/>
                            <rect width="40" height="4" rx="2" transform="matrix(-0.707107 0.707107 0.707107 0.707107 28.2842 0)" fill="white"/>
                        </svg>
                    </button>
                    <h4>Редактировать {{checkCrypto ? 'кошелек': 'карту'}}</h4>
                    <form class="payment-details-form" @submit.prevent="updateFieldValue">
                        <div v-if="!checkCrypto">
                            <small class="form-text text-muted">Держатель карты</small>
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control" name="holder" v-model="holder" @input="checkLenghtInput" placeholder="Держатель карты">
                            </div>
                        </div>
                        <div v-if="checkCrypto">
                            <small class="form-text text-muted"> Название кошелька</small>
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control" name="title" @input="checkLenghtInput" v-model="title" :placeholder="checkCrypto ? 'Название кошелька': 'Название карты'">
                            </div>
                        </div>
                        <small class="form-text text-muted"> {{checkCrypto ? 'Введите адрес кошелька': 'Введите номер карты'}}</small>
                        <div class="form-group">
                            <input type="text" autocomplete="off" class="form-control" v-model="address" @input="checkLenghtInput"  name="address" :placeholder="checkCrypto ? 'Адрес кошелька*': 'Номер карты*'">
                        </div>
                        <button ref="button" class="btn btn-primary confirm-modal"  >Изменить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" @click="$emit('close')"></div>
</div>
</transition>
</template>

<script>
export default {
    props: {
        vTitle: String,
        vAddress: String,
        vHolder: String,
        checkCrypto : Number,
    },
    data() {
        return {
            title: this.vTitle,
            address: this.vAddress,
            holder: this.vHolder
        }
    },
    methods: {
        updateFieldValue() {
            this.$emit('send', {
                title: this.title,
                address: this.address,
                holder: this.holder
                })
        },
        checkLenghtInput(e) {
            if(this.address && this.title && this.checkCrypto || this.address && this.holder && !this.checkCrypto) {
                this.$refs.button.removeAttribute('disabled')
            } else {
                this.$refs.button.setAttribute('disabled', 'disabled')
            }
        }
    },
}

</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity .5s;
}
.modal-enter, .modal-leave-to {
    opacity: 0;
}
</style>
