<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="/favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            <h1 class="mt-4 text-5xl font-bold text-gray-600 dark:text-gray-400">
                Your corner of the internet.
            </h1>

            <a href="{{ route('register') }}" class="bg-slate-900 dark:bg-red-500 text-white sm:text-2xl px-12 py-3 mt-8 sm:mt-12 rounded-lg inline-block duration-300 ease-in-out hover:scale-105">
                Get started
            </a>
        </div>
    </div>
    <div class="pb-8 relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-400 w-400 grid grid-cols-12 md:grid-cols-6 gap-4">
            <div class="col-span-12 md:col-span-3 p-4">
                <div>
                    <img src="{{ asset('images/linkedbi.o_ad.jpg') }}" alt="LinkedBio Advertisement" class="rounded-lg shadow-lg w-full max-w-sm">
                </div>
                <div>
                    <a href="{{ route('register') }}" class="bg-slate-900 dark:bg-red-500 text-white sm:text-2xl px-12 py-3 mt-8 sm:mt-12 rounded-lg inline-block duration-300 ease-in-out hover:scale-105">
                        Get started
                    </a>
                </div>
            </div>
            <div class="col-span-12 md:col-span-3 p-4">
                <img src="{{ asset('images/linkedbi.o_phone.png') }}" alt="LinkedBio Phone View" class="rounded-lg w-full max-w-sm">
            </div>
        </div>
    </div>
</body>

</html>