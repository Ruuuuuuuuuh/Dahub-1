<template>
    <div>
        <home-layout> </home-layout>
        <transition appear name="slideLeft">
            <BurgerNavigation
                v-if="this.$store.state.showBurgerMenu"
            ></BurgerNavigation>
        </transition>
    </div>
</template>

<script>
import HomeLayout from "../layout/HomeLayout";
import BurgerNavigation from "../components/BurgerNavigation";
export default {
    components: { HomeLayout, BurgerNavigation },
    data() {
        return {};
    }
};
</script>

<style scoped>
.slideLeft-enter-active,
.slideLeft-leave-active {
    transition: transform 0.5s cubic-bezier(0.76, 0, 0.24, 1);
}
.slideLeft-enter, .slideLeft-leave-to {
    transform: translateX(-100%);
}
</style>
