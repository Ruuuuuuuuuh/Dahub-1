<template>
    <div>
        <transition  name="slideUp">
            <router-view >
            </router-view>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: "DA-HUB"
        };
    },
    mounted() {
        this.$store.commit('getWindowUser', window.user)
        this.$store.commit('getWindowBalances', window.currency)
        this.$store.commit('getMainScreenbalances', window.visibleWallets)
    }
};
</script>

<style scoped>

</style>
