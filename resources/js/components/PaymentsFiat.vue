<template>
    <div>
        <PaymentsList :crypto="0" :_token="_token"></PaymentsList>
    </div>
</template>

<script>
import PaymentsList from './PaymentsList.vue'
export default {
    props: {
        _token: String
    },
    components: {
        PaymentsList

    }
}
</script>

<style></style>
