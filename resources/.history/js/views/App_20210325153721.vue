<template>
    <v-app>
        <!-- <TopToolbar></TopToolbar> -->
        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
    import TopToolbar from '../components/TopToolbar.vue'

    export default {
        name: 'App',
        components: {
            TopToolbar
        },
    }
</script>

<style scoped>

</style>
