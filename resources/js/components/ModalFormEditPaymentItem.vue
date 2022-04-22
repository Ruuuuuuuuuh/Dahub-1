<template>
    <transition appear name="modal-slide">
        <div class="blur">
            <div class="modal-slide">
                <div class="modal-slide__header">
                    <a href="#" class="cancel" @click.prevent="$emit('close')"
                        >Отменить</a
                    >
                    <a
                        href="#"
                        ref="save"
                        class="save"
                        @click.prevent="updateFieldValue"
                        >Сохранить</a
                    >
                </div>
                <div class="modal-slide__content">
                    <h2 class="modal-slide__title">
                        Редактировать {{ checkCrypto ? "кошелек" : "карту" }}
                    </h2>
                    <form
                        class="payment-details-form"
                        @submit.prevent="updateFieldValue"
                    >
                        <div v-if="!checkCrypto">
                            <div class="form-group">
                                <input
                                    type="text"
                                    autocomplete="off"
                                    class="form-control"
                                    name="holder"
                                    v-model="holder"
                                    @input="checkLenghtInput"
                                    placeholder="Держатель карты"
                                />
                            </div>
                        </div>
                        <div v-if="checkCrypto">
                            <div class="form-group">
                                <input
                                    type="text"
                                    autocomplete="off"
                                    class="form-control"
                                    name="title"
                                    @input="checkLenghtInput"
                                    v-model="title"
                                    :placeholder="
                                        checkCrypto
                                            ? 'Название кошелька'
                                            : 'Название карты'
                                    "
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                autocomplete="off"
                                class="form-control"
                                v-model="address"
                                @input="checkLenghtInput"
                                name="address"
                                :placeholder="
                                    checkCrypto
                                        ? 'Адрес кошелька*'
                                        : 'Номер карты*'
                                "
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        vTitle: String,
        vAddress: String,
        vHolder: String,
        checkCrypto: Number
    },
    data() {
        return {
            title: this.vTitle,
            address: this.vAddress,
            holder: this.vHolder
        };
    },
    methods: {
        updateFieldValue() {
            this.$emit("send", {
                title: this.title,
                address: this.address,
                holder: this.holder
            });
        },
        checkLenghtInput(e) {
            if (
                (this.address && this.title && this.checkCrypto) ||
                (this.address && this.holder && !this.checkCrypto)
            ) {
                this.$refs.save.style.display = "block";
            } else {
                this.$refs.save.style.display = "none";
            }
        }
    }
};
</script>

<style>
.modal-slide form {
    display: flex;
    flex-direction: column;
    padding: 0;
}

.modal-slide input {
    background: #ffffff;
    border-radius: 15px;
    border: none;
    box-shadow: none;
    margin-bottom: 0;
    font-size: 14px;
}
.modal-slide select {
    font-size: 14px;
}

.modal-slide input::placeholder {
    font-size: 14px;
}

.blur {
    position: absolute;
    width: 100%;
    bottom: 0;
    left: 0;
    height: 100%;
    right: 0;
    display: flex;
    flex-direction: column-reverse;
}
.modal-slide {
    height: 85%;
    background: #f2f4fa;
    border-radius: 20px 20px 0px 0px;
    padding: 24px;
}
.modal-slide__header {
    display: flex;
    justify-content: space-between;
}

.modal-slide__title {
    text-align: center;
    margin-top: 50px;
    margin-bottom: 24px;
    font-size: 18px;
}
.modal-slide .save,
.modal-slide .cancel {
    font-weight: 600;
    font-size: 14px;
    line-height: 24px;
    opacity: 0.9;
}
.modal-slide .cancel {
    background: linear-gradient(90.88deg, #ffae34 -29.19%, #ff3998 94.23%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.modal-slide .save {
    background: linear-gradient(85.24deg, #85f362 -116.44%, #02aaff 68.46%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.modal-slide-enter-active,
.modal-slide-leave-active {
    transition: transform 0.2s ease-in-out;
}
.modal-slide-enter,
.modal-slide-leave-to {
    transform: translateY(100%);
}
</style>
