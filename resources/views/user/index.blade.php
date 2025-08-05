<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$user->name}} | {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="/favicon.jpg" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">

    @if ($user->id === auth()->id())
    <div class="flex justify-start p-6 mx-auto text-center">
        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 text-center underline">
            Go to dashboard
        </a>
    </div>
    @endif

    <div class="px-6 sm:p-0 sm:w-3/6 mx-auto mt-8 text-center">

        @if ($user->photo)
            <img src="{{ Storage::disk('s3')->url($user->photo) }}" alt="{{ $user->name }}" class="rounded-full w-28 h-28 mx-auto mb-4 object-cover">
        @endif
        <h1 class="font-semibold text-xl text-gray-600 dark:text-gray-300 text-center">
            {{ $user->name }}
        </h1>

        <p class="text-base  text-gray-600 dark:text-gray-400 mt-2 w:5/6 sm:w-4/5 mx-auto text-center">
            {{ $user->bio }}
        </p>

        <section class="grid grid-flow-row gap-3 sm:gap-4 mt-8">

            @foreach ($links as $link)
            <a href="{{ route('clicks.store', [$user->username, $link, $link->title]) }}" target="_blank" class="border border-gray-500 border-opacity-50 dark:border dark:border-slate-300 dark:border-opacity-30 hover:scale-[1.02] ease-out duration-200 rounded-lg">

                <div class="bg-white/30 dark:bg-gray-800/50 bg-opacity-25 overflow-hidden shadow-sm rounded-lg p-4">
                    <h2 class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $link->title }}
                    </h2>
                </div>

            </a>
            @endforeach

        </section>
        <a href="{{ route('welcome') }}" class="flex items-center">
            <div class="shrink-0 flex items-center justify-center w-full py-4">
                <div class="h-auto w-24 mr-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </div>

                <span class="text-base  text-gray-600 dark:text-gray-400">(beta)
        </a>
    </div>
    </a>
    </div>
</body>

</html>