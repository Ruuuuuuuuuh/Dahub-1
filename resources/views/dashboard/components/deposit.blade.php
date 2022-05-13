<div class="deposit-section @if (!$startTokenSale->isPast()) token-sale-freeze @endif">
    <div class="new-order">
        @if ($startTokenSale->isPast())
        <h2>Получить DHB</h2>
        <h3 class="status-text">Шаг 1 из 3</h3>
        <div class="status-bar">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
        @if ($max > 2000)
        <div class="deposit-block">
            <p class="w-100">Введите количество DHB. <br />Доступно для покупки {{number_format($max, 0, ',', ' ')}} DHB.</p>
            <div class="form-group deposit-amount-wrapper">
                <input type="number" name="deposit-amount" value="2000" step="1000"  data-min="2000" data-max="{{$max}}"  />
            </div>
            <div class="form-group deposit-recieve-group">
                <span style="margin-right:20px;">≈</span>
                <input class="deposit-receive" name="deposit-receive" value="{!! 2000 * Rate::getRates('DHB') !!}"/>
                <div class="deposit-currency-wrapper">
                    <select name="deposit-currency">
                        @foreach ($currencies->get() as $currency)
                            <option value="{{$currency->title}}" @if ($currency->title=='USDT') selected @endif>{{$currency->title}}</option>
                        @endforeach
                    </select>
                    <div class="select-angle">
                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.72487 7.09686C6.32541 7.56931 5.59709 7.56931 5.19763 7.09686L1.01127 2.14566C0.461693 1.49567 0.923708 0.5 1.7749 0.5L10.1476 0.499999C10.9988 0.499999 11.4608 1.49567 10.9112 2.14566L6.72487 7.09686Z" fill="#CECECE"/>
                        </svg>
                    </div>
                </div>

            </div>

            <p class="w-100 mt-2">Выберите платежную систему</p>
            <div class="payment-select">
                <select class="ml-0" name="deposit-payment">
                    @foreach ($currencies->where('title', 'USDT')->first()->payments()->get() as $payment)
                        <option value="{{$payment->title}}">{{$payment->title}}</option>
                    @endforeach
                </select>
                <div class="select-angle">
                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.72487 7.09686C6.32541 7.56931 5.59709 7.56931 5.19763 7.09686L1.01127 2.14566C0.461693 1.49567 0.923708 0.5 1.7749 0.5L10.1476 0.499999C10.9988 0.499999 11.4608 1.49567 10.9112 2.14566L6.72487 7.09686Z" fill="#CECECE"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="subtotal">
            <p>Ваш баланс после покупки:</p>
            <p class="subtotal-amount"><span>{{ number_format(Auth::User()->getBalance('DHB') + 2000, 2, ',',' ')  }}</span> DHB</p>
        </div>

        <a onclick="deposit();" style="margin-top:40px;" class="button button-blue">Получить DHB</a>
        @else
            <p style="margin-top: 25px;margin-bottom: -15px;font-weight: 500;color: #e93878;">Вы уже владеете максимальным количеством DHB</p>
        @endif
        @else
            <div class="start-token-sale-content">
                <h2>Токенсейл <br />остановлен.</h2>
                <h2>Старт через:</h2>
                <div class="timer">
                    <span class="days">{{gmdate("d", $timeNow->diffInSeconds($startTokenSale))}}</span>:<span class="hours">{{gmdate("h", $timeNow->diffInSeconds($startTokenSale))}}</span>:<span class="minutes">{{60 - gmdate("i", $timeNow->diffInSeconds($startTokenSale))}}</span>:<span class="seconds">{{60 - gmdate("s", $timeNow->diffInSeconds($startTokenSale))}}</span>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // конечная дата, например 1 июля 2021
                            const deadline = new Date('{{$startTokenSale}}');
                            // id таймера
                            let timerId = null;
                            // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
                            function countdownTimer() {
                                const diff = deadline - new Date();
                                if (diff <= 0) {
                                    clearInterval(timerId);
                                    alert('Токен сейл запущен!')
                                    window.location.href = '/wallet'
                                }
                                const days = diff > 0 ? Math.floor(diff / 1000 / 60 / 60 / 24): 0;
                                const hours = diff > 0 ? Math.floor(diff / 1000 / 60 / 60) % 24 : 0;
                                const minutes = diff > 0 ? Math.floor(diff / 1000 / 60) % 60 : 0;
                                const seconds = diff > 0 ? Math.floor(diff / 1000) % 60 : 0;
                                $minutes.textContent = minutes < 10 ? '0' + minutes : minutes;
                                $seconds.textContent = seconds < 10 ? '0' + seconds : seconds;
                                $hours.textContent = hours < 10 ? '0' + hours : hours;
                                $days.textContent = days < 10 ? '0' + days : days;
                            }
                            const $days = document.querySelector('.days');
                            const $hours = document.querySelector('.hours');
                            const $minutes = document.querySelector('.minutes');
                            const $seconds = document.querySelector('.seconds');
                            // вызываем функцию countdownTimer
                            countdownTimer();
                            // вызываем функцию countdownTimer каждую секунду
                            timerId = setInterval(countdownTimer, 1000);
                        });
                    </script>
                </div>
                <p>Следите за новостями в нашем<br /> новостном паблике в Telegram.</p>
                <a href="https://t.me/DA_HUB" target="_blank" class="button button-blue"><svg width="35" height="31" viewBox="0 0 35 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.9" d="M-0.000488281 1.1033C0.0541039 1.61002 0.21788 2.20697 0.34071 2.80393C1.20053 7.04508 2.06717 11.2862 2.93381 15.5274C3.91646 20.3586 4.90593 25.1897 5.8954 30.014C6.09329 30.9927 6.84393 31.2773 7.65597 30.6803C9.90105 29.0213 12.1461 27.3624 14.3912 25.7103C14.7597 25.4396 15.1282 25.1689 15.4967 24.8982C16.0767 24.4678 16.6568 24.4678 17.2231 24.9329C18.622 26.0782 20.0073 27.2374 21.3994 28.3966C21.6655 28.6187 21.9385 28.8409 22.3002 28.827C22.7505 28.8131 23.0917 28.5285 23.2487 28.0149C23.6376 26.7793 24.0061 25.5437 24.3883 24.3082C24.9956 22.323 25.6029 20.3377 26.2034 18.3456C26.2853 18.0679 26.4286 17.9083 26.7084 17.8042C29.1923 16.874 31.6694 15.923 34.1533 14.979C34.3785 14.8957 34.6037 14.8055 34.7675 14.6181C35.2383 14.0697 35.0132 13.2784 34.2898 12.9869C33.2321 12.5565 32.1676 12.1539 31.1099 11.7374C26.8995 10.0854 22.6959 8.42641 18.4856 6.78131C14.8006 5.33751 11.1362 3.9076 7.4649 2.4638C5.53373 1.7072 3.60938 0.943651 1.6782 0.187045C1.52808 0.131515 1.37795 0.0690426 1.22782 0.0273945C0.586372 -0.132256 -0.000488281 0.332813 -0.000488281 1.1033ZM24.3746 17.7556C24.3678 17.8042 24.3678 17.943 24.3337 18.0749C23.7809 20.067 23.2282 22.0522 22.6686 24.0444C22.6072 24.2596 22.5117 24.4331 22.2524 24.4192C21.9862 24.4054 21.9317 24.1971 21.8975 23.9819C21.7952 23.2531 21.6723 22.5173 21.6109 21.7815C21.5154 20.6154 21.2083 19.602 20.3007 18.7759C18.2263 16.8879 16.2064 14.9374 14.166 13.0077C12.2758 11.2238 10.3856 9.43984 8.49532 7.64898C8.23601 7.40603 7.98352 7.15614 7.73104 6.90626C7.62868 6.80214 7.56044 6.67719 7.65597 6.53837C7.76516 6.37872 7.89481 6.44813 8.01764 6.51754C8.08588 6.55919 8.15412 6.60084 8.22236 6.64249C9.32784 7.33662 10.4265 8.02381 11.532 8.71795C15.5649 11.2446 19.6047 13.7712 23.6376 16.2979C24.129 16.6172 24.3815 17.0753 24.3746 17.7556Z" fill="white"/>
                    </svg>
                    Подписаться</a>
            </div>
        @endif
    </div>


    <div class="assignee-section">
        <h2>Заявка @if (count(Auth::user()->orders()->notCompleted()->get()) != 0)#{{Auth::user()->orders()->notCompleted()->first()->id}} @endif</h2>
        <p>Ожидайте подтверждения оплаты в течение <strong>24 часов.</strong></p>
    </div>
</div>

