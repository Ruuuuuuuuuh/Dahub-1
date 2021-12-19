@if (gmdate("i", $seconds_left) < 15)
<span class="minutes">{{14 - gmdate("i", $seconds_left)}}</span>:<span class="seconds">{{60 - gmdate("s", $seconds_left)}}</span>
@else
Время вышло
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // конечная дата, например 1 июля 2021
        const deadline = new Date('{{$order->created_at->addMinutes(15)}}');
        // id таймера
        let timerId = null;
        // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
        function countdownTimer() {
            const diff = deadline - new Date();
            if (diff <= 0) {
                clearInterval(timerId);
            }
            const minutes = diff > 0 ? Math.floor(diff / 1000 / 60) % 60 : 0;
            const seconds = diff > 0 ? Math.floor(diff / 1000) % 60 : 0;
            $minutes.textContent = minutes < 10 ? '0' + minutes : minutes;
            $seconds.textContent = seconds < 10 ? '0' + seconds : seconds;
        }
        const $minutes = document.querySelector('.minutes');
        const $seconds = document.querySelector('.seconds');
        // вызываем функцию countdownTimer
        countdownTimer();
        // вызываем функцию countdownTimer каждую секунду
        timerId = setInterval(countdownTimer, 1000);
    });
</script>
