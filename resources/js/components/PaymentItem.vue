<template>
    <a class="payment-item d-flex align-items-center justify-content-between" >

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
            <span class="address" :class="checkCrypto ? 'crypto-adress' : 'card-adress'">{{address}}</span>
            <div class="name">{{checkCrypto ? title : holder}}</div>
        </div>
        <transition appear name="fade">
            <div v-if="editShow" class="action-btn">
                <button type="button" class="icon icon-edit edit-payment_item" @click="$emit('edit')">
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
                </button>
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
        editShow: Boolean
    },
}
</script>

<style>
    .payment-details-icon {
        flex-shrink: 0;
    }
    .payment-details .payment ,.payment-details .name  {
        font-weight: 400 !important;
        font-size: 12px;
        color: #485068;
    }
    .payment-details  .card-adress {
        font-weight: 600;
        font-size: 16px !important;
        color: #0D1F3C;
        margin: 3px 0px;
    }
    .payment-details .crypto-adress {
        font-weight: 600;
        font-size: 10px;
        color: #0D1F3C;
    }
    .payment-item svg {
        fill: #858EA6;
    }
    .payment-item.active svg{
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
