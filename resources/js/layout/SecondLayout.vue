<template>
<transition appear mode="in-out"  name="slideUp">
    <section class="screen opened settings">
        <div class="section-header">
            <div class="top-nav">
                <router-link to="/" class="back-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="#0D1F3C"></path>
                        <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="white"></path>
                        </mask>
                        <g mask="url(#back-link)">
                            <rect width="24" height="24" fill="#0D1F3C"></rect>
                        </g>
                    </svg>
                </router-link>
                <h2>{{title}}</h2>
            </div>
        </div>
        <div class="section-main">
            <slot></slot>
        </div>
    </section>
</transition>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
    .screen {
    position: relative;
    height: 100vh;
    background-color: #fff;
    padding-bottom: 25px;
    overflow: scroll;
    transition: none;
    bottom: 0;
    }

    .slideUp-enter-active,
    .slideUp-leave-active {
        transition: transform .8s cubic-bezier(0.76, 0, 0.24, 1);
    }
    .slideUp-enter {
        transform: translateY(100%);
    }
    .slideUp-leave-to {
        transform: translateY(0%)
    }
</style>
