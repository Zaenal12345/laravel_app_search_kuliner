<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tailwind CSS Simple Email Template Example </title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <style>
            .btn-slide-left {
                background: white !important; 
                border:1px solid #33907C !important; 
                color: #33907C !important
            }
        </style>
    </head>
    <body>
        <div class="flex items-center justify-center min-h-screen p-5 bg-blue-100 min-w-screen">
            <div class="max-w-xl p-8 text-center text-gray-800 bg-white shadow-xl lg:max-w-3xl rounded-3xl lg:p-12">
                <h3 class="text-2xl">SELAMAT! AKUN ANDA BERHASIL DI VERIFIKASI</h3>
                <!-- <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-green-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div> -->

                <div class="flex justify-center" style="padding: 10px">
                    <div style="background-color: white; width: 18%; border-radius: 50%; border: 1px solid #33907C">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#33907C" class="bi bi-check" viewBox="0 0 16 16" style="width:100%;">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                        </svg>
                    </div>
                </div>

                <p>Terima kasih telah melakukan registrasi di <b>#KulinerKhasKu</b>, silahkan tekan tombol dibawah ini untuk membuka aplikasi:</p>
                <div class="mt-4">
                    <button class="px-2 py-2 rounded shadow-md btn-slide-left transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300" > Buka Aplikasi</button>
                </div>
            </div>
        </div>
    </body>
</html>