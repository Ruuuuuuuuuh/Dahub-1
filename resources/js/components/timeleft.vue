<template>
  <p>{{time}}</p>
</template>

<script>

let lastMessage = new Date('2020-01-19 17:54:40'); // Вашу дату не стал трогать в параметре.
let insec1 = lastMessage / 1000; // Переводим дату в секунды
let nextMessage = new Date(lastMessage.setMinutes(lastMessage.getMinutes() + 10));
let insec2 = nextMessage / 1000; // переводим дату следующего сообщения в секунды.
diffsec = insec2 - insec1; // Ищем разницу секунд

export default {
    data: {
        currentTime: diffsec, // Вставляем количество секунд
        time: "", // Задаём переменную time, где будет отображаться с минутами, а не только в секундах.
        timer: null,
    },
    mounted() {
        this.startTimer()
    },
    destroyed() {
        this.stopTimer()
    },
    methods: {
        startTimer() {
            this.timer = setInterval(() => {
                this.currentTime--;
                sec = this.currentTime;
                var h = sec/3600 ^ 0 ;
                var m = (sec-h*3600)/60 ^ 0 ;
                var s = sec-h*3600-m*60 ;
                this.time = (m<10?"0"+m:m)+" мин. "+(s<10?"0"+s:s)+" сек."; // Выводим дату в формате. Можно и часы добавить

            }, 1000)
        },
        stopTimer() {
            clearTimeout(this.timer)
        },
    },
    watch: {
        currentTime(time) {
            if (time === 0) {
                this.stopTimer()
            }
        }
    },
}
</script>

<style>

</style>
