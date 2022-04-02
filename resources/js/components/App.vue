<template>
    <div>
        <router-view/>
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
    }
};
</script>
