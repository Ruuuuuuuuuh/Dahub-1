<template>
    <a class="payment-item d-flex align-items-center justify-content-between" ref="block">

        <svg v-if="checkCrypto" class="payment-details-icon" width="26" height="17" viewBox="0 0 26 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="21" height="17" rx="3" />
            <path d="M26 4C26 2.34315 24.6569 1 23 1V16C24.6569 16 26 14.6569 26 13V4Z" />
            <circle cx="16.5" cy="8.5" r="1.5" fill="white"/>
        </svg>

        <svg v-else-if="!checkCrypto"  class="payment-details-icon" width="26" height="17" viewBox="0 0 26 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="26" height="17" rx="3"/>
        <rect y="10" width="26" height="3" fill="white"/>
        </svg>


        <svg v-else class="payment-details-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" @click="$emit('click')">
            <circle cx="10" cy="10" r="10" fill="#EDF1F9"/>
            <circle class="payment-item-icon-inner" cx="10" cy="10" r="6" fill="#EDF1F9"/>
        </svg>



        <div class="payment-details" @click="$emit('click')">
            <div v-if="!checkCrypto" class="payment">{{payment}}</div>
            <div v-if="checkCrypto" class="name">{{ title ? title + ' / ' : '' }}{{payment}}</div>
            <span class="address" :class="checkCrypto ? 'crypto-adress' : 'card-adress'">{{address}}</span>
            <div v-if="!checkCrypto" class="name">{{ holder}}</div>
        </div>
        <div class="more" @click="checkShowEdit">
            <svg width="5" height="18" viewBox="0 0 5 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="4.13044" height="4.13044" rx="1" fill="#E0E7F0"/>
                <rect y="6.60864" width="4.13044" height="4.13044" rx="1" fill="#E0E7F0"/>
                <rect y="13.2173" width="4.13044" height="4.13044" rx="1" fill="#E0E7F0"/>
            </svg>
        </div>
        <transition appear name="fade">
            <div v-if="action"  class="action" >
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"  @click="checkShowEdit" class="action__close">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5207 1.47962C16.2115 1.17045 15.7103 1.17045 15.4011 1.47962L9.0003 7.88041L2.59951 1.47962L2.53523 1.42191C2.22436 1.17183 1.76847 1.19106 1.47992 1.47962C1.17076 1.78878 1.17076 2.29004 1.47992 2.5992L7.88071 8.99999L1.47992 15.4008L1.42221 15.4651C1.17213 15.7759 1.19137 16.2318 1.47992 16.5204C1.78909 16.8295 2.29034 16.8295 2.59951 16.5204L9.0003 10.1196L15.4011 16.5204L15.4654 16.5781C15.7762 16.8282 16.2321 16.8089 16.5207 16.5204C16.8298 16.2112 16.8298 15.7099 16.5207 15.4008L10.1199 8.99999L16.5207 2.5992L16.5784 2.53492C16.8285 2.22406 16.8092 1.76817 16.5207 1.47962Z"/>
                </svg>
                <div class="action__item" @click="copy">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.70866 8.66669C3.03366 8.66669 3.25033 8.45002 3.25033 8.12502C3.25033 7.80002 3.03366 7.58335 2.70866 7.58335H2.16699C1.84199 7.58335 1.62533 7.36669 1.62533 7.04169V2.16669C1.62533 1.84169 1.84199 1.62502 2.16699 1.62502H7.04199C7.36699 1.62502 7.58366 1.84169 7.58366 2.16669V2.70835C7.58366 3.03335 7.80033 3.25002 8.12533 3.25002C8.45033 3.25002 8.66699 3.03335 8.66699 2.70835V2.16669C8.66699 1.24585 7.96283 0.541687 7.04199 0.541687H2.16699C1.24616 0.541687 0.541992 1.24585 0.541992 2.16669V7.04169C0.541992 7.96252 1.24616 8.66669 2.16699 8.66669H2.70866ZM10.8337 4.33335H5.95866C5.03783 4.33335 4.33366 5.03752 4.33366 5.95835V10.8334C4.33366 11.7542 5.03783 12.4584 5.95866 12.4584H10.8337C11.7545 12.4584 12.4587 11.7542 12.4587 10.8334V5.95835C12.4587 5.03752 11.7545 4.33335 10.8337 4.33335ZM11.3753 10.8334C11.3753 11.1584 11.1587 11.375 10.8337 11.375H5.95866C5.63366 11.375 5.41699 11.1584 5.41699 10.8334V5.95835C5.41699 5.63335 5.63366 5.41669 5.95866 5.41669H10.8337C11.1587 5.41669 11.3753 5.63335 11.3753 5.95835V10.8334Z" />
                    </svg>

                    <span> Копировать</span>
                </div>

                <div class="action__item" @click="edit">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.75033 10.5002H4.08366C4.25866 10.5002 4.37533 10.4418 4.49199 10.3252L10.9087 3.9085C11.142 3.67516 11.142 3.32516 10.9087 3.09183L8.57533 0.758496C8.34199 0.525163 7.99199 0.525163 7.75866 0.758496L1.34199 7.17516C1.22533 7.29183 1.16699 7.4085 1.16699 7.5835V9.91683C1.16699 10.2668 1.40033 10.5002 1.75033 10.5002ZM2.33354 7.81683L8.16688 1.9835L9.68355 3.50016L3.85021 9.3335H2.33354V7.81683ZM12.2503 13.4167C12.6003 13.4167 12.8337 13.1834 12.8337 12.8334C12.8337 12.4834 12.6003 12.25 12.2503 12.25H1.75033C1.40033 12.25 1.16699 12.4834 1.16699 12.8334C1.16699 13.1834 1.40033 13.4167 1.75033 13.4167H12.2503Z"/>
                    </svg>

                    <span> Редактировать</span>
                </div>
                <div class="action__item" @click="remove">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2503 2.91665H9.91699V2.33331C9.91699 1.34165 9.15866 0.583313 8.16699 0.583313H5.83366C4.84199 0.583313 4.08366 1.34165 4.08366 2.33331V2.91665H1.75033C1.40033 2.91665 1.16699 3.14998 1.16699 3.49998C1.16699 3.84998 1.40033 4.08331 1.75033 4.08331H2.33366V11.6666C2.33366 12.6583 3.09199 13.4166 4.08366 13.4166H9.91699C10.9087 13.4166 11.667 12.6583 11.667 11.6666V4.08331H12.2503C12.6003 4.08331 12.8337 3.84998 12.8337 3.49998C12.8337 3.14998 12.6003 2.91665 12.2503 2.91665ZM5.25033 2.33331C5.25033 1.98331 5.48366 1.74998 5.83366 1.74998H8.16699C8.51699 1.74998 8.75033 1.98331 8.75033 2.33331V2.91665H5.25033V2.33331ZM9.91699 12.25C10.267 12.25 10.5003 12.0166 10.5003 11.6666V4.08331H3.50033V11.6666C3.50033 12.0166 3.73366 12.25 4.08366 12.25H9.91699ZM6.41699 6.41665V9.91665C6.41699 10.2666 6.18366 10.5 5.83366 10.5C5.48366 10.5 5.25033 10.2666 5.25033 9.91665V6.41665C5.25033 6.06665 5.48366 5.83331 5.83366 5.83331C6.18366 5.83331 6.41699 6.06665 6.41699 6.41665ZM8.75033 9.91665V6.41665C8.75033 6.06665 8.51699 5.83331 8.16699 5.83331C7.81699 5.83331 7.58366 6.06665 7.58366 6.41665V9.91665C7.58366 10.2666 7.81699 10.5 8.16699 10.5C8.51699 10.5 8.75033 10.2666 8.75033 9.91665Z"/>
                        </svg>


                   <span> Удалить</span>
                </div>


                <!-- <button type="button" class="icon icon-edit edit-payment_item" @click="$emit('edit')">
                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="17" cy="17" r="17" fill="url(#paint0_linear_1227_1175)"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8797 21.08H13.5997C13.8037 21.08 13.9397 21.012 14.0757 20.876L21.5557 13.396C21.8277 13.124 21.8277 12.716 21.5557 12.444L18.8357 9.72402C18.5637 9.45202 18.1557 9.45202 17.8837 9.72402L10.4037 17.204C10.2677 17.34 10.1997 17.476 10.1997 17.68V20.4C10.1997 20.808 10.4717 21.08 10.8797 21.08ZM11.5597 17.952L18.3597 11.152L20.1277 12.92L13.3277 19.72H11.5597V17.952ZM23.1197 24.48C23.5277 24.48 23.7997 24.208 23.7997 23.8C23.7997 23.392 23.5277 23.12 23.1197 23.12H10.8797C10.4717 23.12 10.1997 23.392 10.1997 23.8C10.1997 24.208 10.4717 24.48 10.8797 24.48H23.1197Z" fill="black"/>
                    <mask id="mask0_1227_1175" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="10" y="9" width="14" height="16">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8797 21.08H13.5997C13.8037 21.08 13.9397 21.012 14.0757 20.876L21.5557 13.396C21.8277 13.124 21.8277 12.716 21.5557 12.444L18.8357 9.72402C18.5637 9.45202 18.1557 9.45202 17.8837 9.72402L10.4037 17.204C10.2677 17.34 10.1997 17.476 10.1997 17.68V20.4C10.1997 20.808 10.4717 21.08 10.8797 21.08ZM11.5597 17.952L18.3597 11.152L20.1277 12.92L13.3277 19.72H11.5597V17.952ZM23.1197 24.48C23.5277 24.48 23.7997 24.208 23.7997 23.8C23.7997 23.392 23.5277 23.12 23.1197 23.12H10.8797C10.4717 23.12 10.1997 23.392 10.1997 23.8C10.1997 24.208 10.4717 24.48 10.8797 24.48H23.1197Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0_1227_1175)">
                    <rect x="8.83984" y="8.84003" width="16.32" height="16.32" fill="white"/>
                    </g>
                    <defs>
                    <linearGradient id="paint0_linear_1227_1175" x1="-43.7143" y1="24.0833" x2="23.9205" y2="18.446" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#85F362"/>
                    <stop offset="1" stop-color="#02AAFF"/>
                    </linearGradient>
                    </defs>
                    </svg>
                </button>
                <button type="button" class="icon icon-delete delete-payment_item" @click="$emit('remove')">
                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.9" cx="17" cy="17" r="17" fill="url(#paint0_linear_1227_1172)"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1197 12.2401H20.3997V11.5601C20.3997 10.4041 19.5157 9.52008 18.3597 9.52008H15.6397C14.4837 9.52008 13.5997 10.4041 13.5997 11.5601V12.2401H10.8797C10.4717 12.2401 10.1997 12.5121 10.1997 12.9201C10.1997 13.3281 10.4717 13.6001 10.8797 13.6001H11.5597V22.4401C11.5597 23.5961 12.4437 24.4801 13.5997 24.4801H20.3997C21.5557 24.4801 22.4397 23.5961 22.4397 22.4401V13.6001H23.1197C23.5277 13.6001 23.7997 13.3281 23.7997 12.9201C23.7997 12.5121 23.5277 12.2401 23.1197 12.2401ZM14.9597 11.5601C14.9597 11.1521 15.2317 10.8801 15.6397 10.8801H18.3597C18.7677 10.8801 19.0397 11.1521 19.0397 11.5601V12.2401H14.9597V11.5601ZM20.3997 23.1201C20.8077 23.1201 21.0797 22.8481 21.0797 22.4401V13.6001H12.9197V22.4401C12.9197 22.8481 13.1917 23.1201 13.5997 23.1201H20.3997ZM16.3197 16.3201V20.4001C16.3197 20.8081 16.0477 21.0801 15.6397 21.0801C15.2317 21.0801 14.9597 20.8081 14.9597 20.4001V16.3201C14.9597 15.9121 15.2317 15.6401 15.6397 15.6401C16.0477 15.6401 16.3197 15.9121 16.3197 16.3201ZM19.0397 20.4001V16.3201C19.0397 15.9121 18.7677 15.6401 18.3597 15.6401C17.9517 15.6401 17.6797 15.9121 17.6797 16.3201V20.4001C17.6797 20.8081 17.9517 21.0801 18.3597 21.0801C18.7677 21.0801 19.0397 20.8081 19.0397 20.4001Z" fill="black"/>
                    <mask id="mask0_1227_1172" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="10" y="9" width="14" height="16">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1197 12.2401H20.3997V11.5601C20.3997 10.4041 19.5157 9.52008 18.3597 9.52008H15.6397C14.4837 9.52008 13.5997 10.4041 13.5997 11.5601V12.2401H10.8797C10.4717 12.2401 10.1997 12.5121 10.1997 12.9201C10.1997 13.3281 10.4717 13.6001 10.8797 13.6001H11.5597V22.4401C11.5597 23.5961 12.4437 24.4801 13.5997 24.4801H20.3997C21.5557 24.4801 22.4397 23.5961 22.4397 22.4401V13.6001H23.1197C23.5277 13.6001 23.7997 13.3281 23.7997 12.9201C23.7997 12.5121 23.5277 12.2401 23.1197 12.2401ZM14.9597 11.5601C14.9597 11.1521 15.2317 10.8801 15.6397 10.8801H18.3597C18.7677 10.8801 19.0397 11.1521 19.0397 11.5601V12.2401H14.9597V11.5601ZM20.3997 23.1201C20.8077 23.1201 21.0797 22.8481 21.0797 22.4401V13.6001H12.9197V22.4401C12.9197 22.8481 13.1917 23.1201 13.5997 23.1201H20.3997ZM16.3197 16.3201V20.4001C16.3197 20.8081 16.0477 21.0801 15.6397 21.0801C15.2317 21.0801 14.9597 20.8081 14.9597 20.4001V16.3201C14.9597 15.9121 15.2317 15.6401 15.6397 15.6401C16.0477 15.6401 16.3197 15.9121 16.3197 16.3201ZM19.0397 20.4001V16.3201C19.0397 15.9121 18.7677 15.6401 18.3597 15.6401C17.9517 15.6401 17.6797 15.9121 17.6797 16.3201V20.4001C17.6797 20.8081 17.9517 21.0801 18.3597 21.0801C18.7677 21.0801 19.0397 20.8081 19.0397 20.4001Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0_1227_1172)">
                    <rect x="8.83984" y="8.84009" width="16.32" height="16.32" fill="white"/>
                    </g>
                    <defs>
                    <linearGradient id="paint0_linear_1227_1172" x1="-0.0687604" y1="17.8559" x2="32.2494" y2="18.3025" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#FFAE34"/>
                    <stop offset="1" stop-color="#FF3998"/>
                    </linearGradient>
                    </defs>
                    </svg>

                </button> -->
            </div>
            </transition>
    </a>
</template>

<script>
export default {
    props: {
        title: String,
        address: String,
        payment: String,
        id: Number,
        holder: String,
        checkCrypto: Number,
        editShow: Boolean,
    },
    data() {
        return {
            action: this.editShow
        }
    },
    methods: {

        checkShowEdit() {
            this.action = !this.action
            if(this.action) {
                this.$refs.block.classList.add('active')
            } else {
                this.$refs.block.classList.remove('active')
            }
            this.$emit('action', {
                action: this.action
            })
        },
        edit () {
            this.$emit('edit', {
            })
            this.action = false
             if(this.action) {
                this.$refs.block.classList.add('active')
            } else {
                this.$refs.block.classList.remove('active')
            }
        },

        remove () {
            this.$emit('remove', {
            })
            this.action = false
        },
        copy () {
            this.$emit('copy', {
            })
            this.action = false
        }
    },
    // watch: {
    //     active: function() {

    //     }
    // },
    created() {
        const onClick = (e) => {
            this.action = this.$refs.block.contains(e.target) && this.action;
            if(this.action) {
                this.$refs.block.classList.add('active')
            } else {
                this.$refs.block.classList.remove('active')
            }
        }
        document.addEventListener('click', onClick);
        this.$on('hook:beforeDestroy', () => document.removeEventListener('click', onClick));
        },
}
</script>

<style>
    .more {
        padding-left: 10px;
    }
    .action {
        display: flex;
        position: absolute;
        right: -20px;
        top: 22px;
        z-index: 1;
        flex-direction: column;
        padding: 14px 16px 28px;
        background: #F2F4FA;
        border-radius: 20px;
        min-width: 200px;
    }

    .action__item svg {
        margin-right: 10px;
        fill: #B5BBC9;
    }
    .action__item {
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        color: #78839C;
        border-bottom: 1px solid #D6E0F7;
        padding: 8px 0px;
        display: flex;
        align-items: center;
        transition: all .3s ease;
    }
    .action__item:last-of-type {
        border-bottom: none;
    }
    .action__item:hover {
        color:#49576D;
    }

    .action__item:hover svg {
        fill: #02AAFF;
    }

    .action__close {
        align-self: flex-end;
        fill:#858EA6;
    }

    .action__close:hover {
        fill: #02AAFF;
    }
    .payment-details-icon {
        flex-shrink: 0;
    }
    .payment-details .payment ,.payment-details .name  {
        font-weight: 300 !important;
        font-size: 14px;
        line-height: 20px;
        color: #485068;
    }
    .payment-details  .card-adress {
        font-weight: 600;
        line-height: 24px !important;
        font-size: 16px !important;
        color: #0D1F3C;
    }
    .payment-details .crypto-adress {
        font-weight: 600;
        font-size: 10px;
        line-height: 24px !important;
        color: #0D1F3C;
    }
    .payment-item .payment-details-icon  {
        fill: #858EA6;
    }
    .payment-item.active  .payment-details-icon {
        fill: #02AAFF;
    }

    .payment-item.active-accept-order  .payment-details-icon {
        fill: #02AAFF;
    }
    .fade-enter-active,
    .fade-leave-active {
    transition: opacity 0.2s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
    opacity: 0;
    }

</style>
