<template>
    <main>
        <header class="header">
            <div class="header-top-icons d-flex justify-content-between">
                <button class="navbar-open" @click="openMenu()">
                    <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7H20C20.6 7 21 6.6 21 6C21 5.4 20.6 5 20 5H2C1.4 5 1 5.4 1 6C1 6.6 1.4 7 2 7ZM21 12C21 12.6 20.6 13 20 13H2C1.4 13 1 12.6 1 12C1 11.4 1.4 11 2 11H20C20.6 11 21 11.4 21 12ZM2 17H20C20.6 17 21 17.4 21 18C21 18.6 20.6 19 20 19H2C1.4 19 1 18.6 1 18C1 17.4 1.4 17 2 17Z" fill="black"/>
                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="1" y="5" width="20" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7H20C20.6 7 21 6.6 21 6C21 5.4 20.6 5 20 5H2C1.4 5 1 5.4 1 6C1 6.6 1.4 7 2 7ZM21 12C21 12.6 20.6 13 20 13H2C1.4 13 1 12.6 1 12C1 11.4 1.4 11 2 11H20C20.6 11 21 11.4 21 12ZM2 17H20C20.6 17 21 17.4 21 18C21 18.6 20.6 19 20 19H2C1.4 19 1 18.6 1 18C1 17.4 1.4 17 2 17Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0)">
                            <rect x="-1" width="24" height="24" fill="#B5BBC9"/>
                        </g>
                    </svg>
                </button>
                <router-link :to="{name: 'settings'}">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.3 15.4C20.4 15.2 20.6 15 21 15C22.7 15 24 13.7 24 12C24 10.3 22.7 9 21 9H20.8C20.6 9 20.4 8.9 20.3 8.7C20.3 8.6 20.3 8.6 20.2 8.5C20.1 8.3 20.1 8 20.4 7.7C21.6 6.5 21.6 4.6 20.4 3.5C19.8 2.9 19.1 2.6 18.3 2.6C17.5 2.6 16.7 2.9 16.1 3.5C15.9 3.7 15.6 3.7 15.4 3.6C15.2 3.6 15 3.3 15 3C15 1.3 13.7 0 12 0C10.3 0 9 1.3 9 3V3.2C9 3.4 8.9 3.6 8.7 3.7C8.6575 3.7 8.63307 3.7 8.61134 3.70767C8.58194 3.71806 8.5575 3.7425 8.5 3.8C8.3 3.9 8 3.8 7.7 3.6C6.5 2.4 4.6 2.4 3.5 3.6C2.3 4.8 2.3 6.7 3.6 7.9C3.8 8.1 3.8 8.4 3.7 8.7C3.6 8.9 3.3 9.1 3 9.1C1.3 9.1 0 10.4 0 12.1C0 13.8 1.3 15.1 3 15.1H3.2C3.5 15.1 3.7 15.3 3.8 15.5C3.9 15.7 3.9 16 3.6 16.3C3 16.9 2.7 17.6 2.7 18.4C2.7 19.2 3 19.9 3.6 20.5C4.8 21.7 6.7 21.7 7.9 20.4C8.1 20.2 8.4 20.2 8.7 20.3C9 20.4 9.1 20.6 9.1 21C9.1 22.7 10.4 24 12.1 24C13.8 24 15.1 22.7 15.1 21V20.8C15.1 20.5 15.3 20.3 15.5 20.2C15.7 20.1 16 20.1 16.3 20.4C17.5 21.6 19.4 21.6 20.5 20.4C21.7 19.2 21.7 17.3 20.4 16.1C20.3 15.9 20.2 15.6 20.3 15.4ZM8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12ZM10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10C10.9 10 10 10.9 10 12ZM19.1 17.6C18.3 16.7 18.1 15.6 18.5 14.6C18.9 13.6 19.9 13 20.9 13C21.6 13 22 12.6 22 12C22 11.4 21.6 11 21 11H20.8C19.8 11 18.8 10.4 18.4 9.4C18.3 9.3 18.3 9.2 18.3 9.1C18 8.2 18.2 7.1 18.9 6.4C19.4 5.9 19.4 5.3 19 4.9C18.8 4.7 18.6 4.6 18.3 4.6C18 4.6 17.8 4.7 17.6 4.9C16.7 5.7 15.6 5.9 14.6 5.5C13.6 5.1 13 4.2 13 3.1C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V3.2C11 4.2 10.4 5.2 9.4 5.6C9.3 5.7 9.2 5.7 9.1 5.7C8.2 6 7.1 5.8 6.4 5.1C5.9 4.6 5.3 4.6 4.9 5C4.5 5.4 4.5 6 4.9 6.4C5.7 7.3 5.9 8.4 5.5 9.4C5.1 10.4 4.2 11.1 3.1 11.1H3C2.4 11.1 2 11.5 2 12.1C2 12.7 2.4 13.1 3 13.1H3.2C4.2 13.1 5.2 13.7 5.6 14.7C6.1 15.7 5.9 16.8 5.1 17.6C4.8 17.9 4.7 18.1 4.7 18.4C4.7 18.7 4.8 18.9 5 19.1C5.4 19.5 6 19.5 6.4 19.1C6.9 18.6 7.6 18.3 8.3 18.3C8.7 18.3 9.1 18.3 9.4 18.5C10.4 18.9 11.1 19.8 11.1 20.9V21C11.1 21.6 11.5 22 12.1 22C12.7 22 13.1 21.6 13.1 21V20.8C13.1 19.8 13.7 18.8 14.7 18.4C15.7 17.9 16.8 18.1 17.6 18.9C17.9 19.2 18.1 19.3 18.4 19.3C18.7 19.3 18.9 19.2 19.1 19C19.3 18.8 19.4 18.6 19.4 18.3C19.4 18 19.3 17.8 19.1 17.6Z" fill="#CFD2D8"/>
                    </svg>
                </router-link>
            </div>
            <Balances></Balances>
        </header>

            <vue-draggable-resizable w="auto" :min-height="140" :max-height="stoperResize" class-name="ordersResize" :h="heightOrdersContainer" :draggable="false" @resizestop="resizestop"  :active="true" :prevent-deactivation="true" :handles="['tm']">
                    <div slot="tm">
                        <div class="screen-rollover">
                            <svg width="44" height="44" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="18" cy="18" r="18" fill="#347AF0"/>
                                <path d="M18.375 6.38571C18.125 6.12857 17.75 6 17.5 6C17.25 6 16.875 6.12857 16.625 6.38571L10.375 12.8143C9.875 13.3286 9.875 14.1 10.375 14.6143C10.875 15.1286 11.625 15.1286 12.125 14.6143L17.5 9.08571L22.875 14.6143C23.375 15.1286 24.125 15.1286 24.625 14.6143C25.125 14.1 25.125 13.3286 24.625 12.8143L18.375 6.38571Z" fill="white"/>
                                <path d="M16.625 28.6143C16.875 28.8714 17.25 29 17.5 29C17.75 29 18.125 28.8714 18.375 28.6143L24.625 22.1857C25.125 21.6714 25.125 20.9 24.625 20.3857C24.125 19.8714 23.375 19.8714 22.875 20.3857L17.5 25.9143L12.125 20.3857C11.625 19.8714 10.875 19.8714 10.375 20.3857C9.875 20.9 9.875 21.6714 10.375 22.1857L16.625 28.6143Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                    <Orders></Orders>
                </vue-draggable-resizable>

        <slot></slot>
        <Footer/>
    </main>
</template>

<script>
import Footer from "../components/Footer"
import Balances from '../components/Balances'
import Orders from '../components/Orders'

export default {
    components: {
        Footer,
        Balances,
        Orders,
    },
    data() {
        return {
            stoperResize: window.innerHeight - 75,
            heightOrdersContainer: window.innerHeight / 2
        }
    },
    methods: {
        resizestop: function(x, y, width, height) {
            console.log(x, y, width, height)
            console.log(window.innerHeight - 100)
        },
        openMenu() {
            this.$store.commit('changeVisibilityBurgerMenu')
        },
        swipeResize(event) {
            console.log("Высота экрана " + window.innerHeight)
            console.log("Высота обьекта " +this.$refs.resizable.clientHeight)
            console.log(event)
        }
    }
}
</script>


<style lang="scss" scoped>
    main {
        height: 100vh;

    }
    .header {
        color: #fff;
        padding: 35px 25px 50px;
        height: auto;
    }

    button {
        background: transparent;
    }

    .screen-rollover {
    position: absolute;
    top: -19px;
    left: 0;
    cursor: grab;
    width: 100%;
    text-align: center;
    svg {
        border: 4px solid white;
        border-radius: 100%;
    }
    }
    .ordersResize {
        min-width: 100%;
        background-color: #fff;
        border-radius: 20px 20px 0 0;
        position: absolute;
        top: 50vh;
        // min-height: 50vh;
        box-sizing: content-box;
        z-index: 1;
    }
</style>
