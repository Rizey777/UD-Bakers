<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Konfirmasi Pembayaran</h2>
    </x-slot>

    <div class="container-confirmation">
        <p>Silakan pilih jenis kue dan lakukan pembayaran dengan memindai QRIS berikut:</p>

        <div id="countdown-timer">Waktu tersisa: 05:00</div>

        <div>
            <label class="label-radio">
                <input type="radio" name="jenis_kue" value="kering" class="jenis-kue-radio" />
                <span>Kue Kering</span>
            </label>

            <label class="label-radio">
                <input type="radio" name="jenis_kue" value="basah" class="jenis-kue-radio" />
                <span>Kue Basah</span>
            </label>
        </div>

        <div id="qris-kering" class="qris-container hidden">
            <img src="{{ asset('storage/qris.jpg') }}" alt="QRIS Kue Kering" />
            <p>QRIS untuk pembayaran Kue Kering</p>
        </div>

        <div id="qris-basah" class="qris-container hidden">
            <img src="{{ asset('storage/gopay.jpg') }}" alt="QRIS Kue Basah" />
            <p>QRIS untuk pembayaran Kue Basah</p>
        </div>

        <form action="{{ route('order.success', ['order' => $order->id]) }}" method="POST" id="payment-form">
            @csrf
            <button type="submit" id="submit-button" disabled>Sudah Bayar</button>
        </form>
    </div>

    <style>
        /* Container utama */
        .container-confirmation {
            max-width: 480px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #374151; /* gray-700 */
            text-align: center;
        }

        /* Paragraf */
        .container-confirmation p {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        /* Timer */
        #countdown-timer {
            font-weight: 700;
            font-size: 1.25rem;
            color: #dc2626; /* red-600 */
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
        }

        /* Label radio custom */
        .label-radio {
            display: inline-flex;
            align-items: center;
            margin-right: 1.5rem;
            cursor: pointer;
            user-select: none;
            font-weight: 600;
            color: #4b5563; /* gray-600 */
            transition: color 0.3s ease;
        }

        /* Hide actual radio input */
        .label-radio input[type="radio"] {
            display: none;
        }

        /* Custom styled span acting as button */
        .label-radio span {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: 2px solid #d1d5db; /* gray-300 */
            background-color: #f9fafb; /* gray-50 */
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.05);
            transition: all 0.3s ease;
        }

        /* Hover efek tombol */
        .label-radio:hover span {
            background-color: #e5e7eb; /* gray-200 */
            border-color: #9ca3af; /* gray-400 */
        }

        /* Saat radio dicentang */
        .label-radio input[type="radio"]:checked + span {
            background-color: #3b82f6; /* blue-500 */
            color: white;
            border-color: #2563eb; /* blue-600 */
            box-shadow: 0 0 12px #2563ebaa;
        }

        /* Fokus keyboard */
        .label-radio input[type="radio"]:focus + span {
            outline: 2px solid #60a5fa; /* blue-400 */
            outline-offset: 2px;
        }

        /* QRIS container */
        .qris-container {
            margin-bottom: 1.75rem;
        }

        .qris-container img {
            width: 16rem;
            height: 16rem;
            object-fit: contain;
            border: 2px solid #e5e7eb; /* gray-200 */
            border-radius: 0.75rem;
            margin: 0 auto;
            display: block;
        }

        .qris-container p {
            margin-top: 0.75rem;
            font-size: 0.875rem;
            color: #6b7280; /* gray-500 */
        }

        /* Tombol submit */
        #submit-button {
            background-color: #2563eb; /* blue-600 */
            color: white;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 1.125rem;
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            display: block;
        }

        #submit-button:hover:not(:disabled) {
            background-color: #1d4ed8; /* blue-700 */
            box-shadow: 0 10px 20px rgba(29, 78, 216, 0.4);
        }

        #submit-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            box-shadow: none;
        }
    </style>

    <script>
        const radios = document.querySelectorAll('.jenis-kue-radio');
        const submitButton = document.getElementById('submit-button');
        const qrisKering = document.getElementById('qris-kering');
        const qrisBasah = document.getElementById('qris-basah');
        const timerDisplay = document.getElementById('countdown-timer');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                qrisKering.classList.add('hidden');
                qrisBasah.classList.add('hidden');

                if(this.value === 'kering') {
                    qrisKering.classList.remove('hidden');
                } else if(this.value === 'basah') {
                    qrisBasah.classList.remove('hidden');
                }

                submitButton.disabled = false;
            });
        });

        document.getElementById('payment-form').addEventListener('submit', function(e){
            const checked = document.querySelector('.jenis-kue-radio:checked');
            if(!checked) {
                e.preventDefault();
                alert('Silakan pilih jenis kue terlebih dahulu sebelum melanjutkan.');
            }
        });

        let timeLeft = 300;
        const countdownInterval = setInterval(() => {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            timerDisplay.textContent = `Waktu tersisa: ${minutes}:${seconds}`;

            if(timeLeft <= 0){
                clearInterval(countdownInterval);
                timerDisplay.textContent = 'Waktu pembayaran telah habis. Silakan pilih ulang dan coba kembali.';

                radios.forEach(radio => {
                    radio.checked = false;
                });

                qrisKering.classList.add('hidden');
                qrisBasah.classList.add('hidden');
                submitButton.disabled = true;

                timeLeft = 300;
            }

            timeLeft--;
        }, 1000);
    </script>
</x-app-layout>
