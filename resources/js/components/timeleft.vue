<template>
    <div class="d-flex align-items-center">
        <p class="timer" v-if="leavesTimeTimer > 0">{{ hours.toString().padStart(2, '0') }}<span>:</span>{{ minutes.toString().padStart(2, '0') }}<span>:</span>{{ seconds.toString().padStart(2, '0') }}</p>
        <p class="text" v-else>Вермя вышло</p>
        <div class="danger" v-if="showDanger">
            {{dangerText}}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            leavesTime: Number
        },
        data() {
            return {
                leavesTimeTimer: this.leavesTime > 0 ? parseInt(this.leavesTime) : 0,
                hours: Number,
                minutes: Number,
                seconds: Number,
                timer: '',
                showDanger: false,
                dangerText: 'Заявка скоро отмениться',
                timeDangerShow: ''
            }
        },
        methods: {
            startTimer() {
                this.updateMin()
                if(this.leavesTimeTimer <= 300 && this.leavesTimeTimer >= 0) {
                    this.showDanger = true
                } else {
                    this.showDanger = false
                }
                if(this.leavesTimeTimer > 0 ) {
                    this.timer = setInterval(() => {
                        this.leavesTimeTimer-=1
                        this.updateMin()
                    }, 1000)
                } else {
                    this.showDanger = false
                }

            },
            updateMin(){
                this.hours = Math.floor(this.leavesTimeTimer / 60 / 60)
                this.minutes = Math.floor(this.leavesTimeTimer / 60) - (this.hours * 60)
                this.seconds = this.leavesTimeTimer % 60;
            },
            stopTimer() {
                clearTimeout(this.timer)
                // alert('Время кончилось')
                // location.reload()

            }
        },
        mounted() {
            this.startTimer()
        },
        watch: {
            leavesTimeTimer(time) {
                if (time === 0) {
                    this.stopTimer()
                }
                if(time <= 300 && time != 0) {
                    this.showDanger = true
                } else {
                    this.showDanger = false
                }
            }
        }
    }
</script>

<style scoped>
    .timer {
        font-feature-settings: 'tnum' on, 'lnum' on;
    }
    .timer span {
        opacity: .3;
        display: inline;
        margin: 0px 1px;
        font-weight: 500;
        animation-duration: 1s;
        animation-name: pulse;
        animation-iteration-count: infinite;
        transition: opacity .3s linear ;
    }
    .danger {
        margin-left: 4px;
        font-size: 13px;
        padding: 6px;
        background: #DF5060;
        border-radius: 4px;
        color: #fff;
        line-height: 1;
    }
    @keyframes pulse {
        0% {
            opacity: .3;
        }
        50% {
            opacity: .5;
        }
        100% {
            opacity: .3;
        }
    }
</style>
