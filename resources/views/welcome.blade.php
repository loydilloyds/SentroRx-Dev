<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    </head>
    <body class="font-sans antialiased text-black bg-srx-white">
        <header class="py-6 flex justify-between px-32 shadow-md">
            <a href="/">
                <x-application-logo class="h-9"/>
            </a>
            <nav class="flex gap-4 items-center font-medium">
                <a href="/" class="nav">Home</a>
                <a href="/appointments" class="nav">Appointments</a>
                <a href="{{ route('register') }}"
                   class="nav welcome-secondary-button leading-none">
                    Sign Up
                </a>
                <a href="{{ route('login') }}"
                   class="nav welcome-primary-button leading-none">
                    Log In
                </a>
            </nav>
        </header>

        <main class="px-32">
            <section class="border">
                <div class="container flex flex-col justify-center p-6 mx-auto sm:py-12 lg:py-24 lg:flex-row lg:justify-between">
                    <div class="flex flex-col justify-center text-center rounded-sm lg:max-w-md xl:max-w-2xl lg:text-left">
                        <h1 class="text-5xl font-bold leading-none sm:text-6xl">
                            Welcome to SentroRx - Your Convenient Health Center Appointments
                        </h1>
                        <p class="mt-6 mb-8 text-lg sm:mb-12">
                            Book appointments easily and get notified about medication availability.
                        </p>
                        <div class="flex flex-col space-y-4 sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start">
                            <a rel="noopener noreferrer" href="#"
                               class="welcome-primary-button px-8 py-3 text-lg font-semibold rounded">
                                Learn More
                            </a>
                            <a rel="noopener noreferrer" href="{{ route('register') }}"
                               class="welcome-secondary-button px-8 py-3 text-lg font-semibold border rounded">
                                Sign Up
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center justify-center p-6 mt-8 lg:mt-0 h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
                        <img src="" alt="" class="object-contain h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
                    </div>
                </div>
            </section>
            <section class="pt-28">
                <div class="text-center">
                    <p class="font-bold">
                        Convenient
                    </p>
                    <h2 class="text-5xl font-bold pt-4 pb-6">
                        Book with SentroRx Today
                    </h2>
                    <p class="font-medium">
                        Save time and stay informed with SentroRx's services.
                    </p>
                </div>
                <div class="mt-20 space-y-16">
                    <div class="grid grid-cols-2 border border-2">
                        <div class="flex flex-col justify-center content-center p-12 leading-normal">
                            <p class="font-semibold">Easy</p>
                            <h5 class="mt-2 mb-6 text-4xl font-bold tracking-tight text-gray-900">Manage Your Health Effortlessly</h5>
                            <p class="mb-6 font-normal text-gray-700">Discover the convenience of booking appointments and receiving medication notifications with SentroRx. Say goodbye to long waiting times and uncertainty.</p>
                            <div class="flex flex-col gap-6 sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start">
                                <a rel="noopener noreferrer" href="#"
                                   class="welcome-secondary-button px-5 py-3 text-sm font-semibold rounded">
                                    Learn More
                                </a>
                                <a rel="noopener noreferrer"href="{{ route('register') }}" class="inline-flex items-center gap-2.5 text-srx-blue hover:text-srx-green transition duration-300 ease-in-out">
                                    Sign Up
                                    <x-heroicons::outline.chevron-right class="h-5 w-auto"/>
                                </a>
                            </div>
                        </div>
                        <img class="object-cover w-auto h-[40rem] rounded-t-lg md:w-1/2 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="">
                    </div>
                    <div class="grid grid-cols-2 border border-2">
                        <img class="object-cover w-auto h-[40rem] rounded-t-lg md:w-1/2 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="">
                        <div class="flex flex-col justify-center content-center p-12 leading-normal">
                            <p class="font-semibold">Convenient</p>
                            <h5 class="mt-2 mb-6 text-4xl font-bold tracking-tight text-gray-900">Stay Informed, Stay Healthy</h5>
                            <p class="mb-6 font-normal text-gray-700">Take control of your health with SentroRx. Book appointments and receive medication notifications with ease.</p>
                            <div class="flex flex-col gap-6 sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start">
                                <a rel="noopener noreferrer" href="#"
                                   class="welcome-secondary-button px-5 py-3 text-sm font-semibold rounded">
                                    Learn More
                                </a>
                                <a rel="noopener noreferrer" href="{{ route('register') }}" class="inline-flex items-center gap-2.5 text-srx-blue hover:text-srx-green transition duration-300 ease-in-out">
                                    Sign Up
                                    <x-heroicons::outline.chevron-right class="h-5 w-auto"/>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 border border-2">
                        <div class="flex flex-col justify-center content-center p-12 leading-normal">
                            <p class="font-semibold">Efficient</p>
                            <h5 class="mt-2 mb-6 text-4xl font-bold tracking-tight text-gray-900">Streamline Your Health Management Process</h5>
                            <p class="mb-6 font-normal text-gray-700">SentroRx simplifies the process of booking appointments and receiving medication notifications. Experience efficiency like never before.</p>
                            <div class="flex flex-col gap-6 sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start">
                                <a rel="noopener noreferrer" href="#"
                                   class="welcome-secondary-button px-5 py-3 text-sm font-semibold rounded">
                                    Learn More
                                </a>
                                <a rel="noopener noreferrer" href="{{ route('register') }}" class="inline-flex items-center gap-2.5 text-srx-blue hover:text-srx-green transition duration-300 ease-in-out">
                                    Sign Up
                                    <x-heroicons::outline.chevron-right class="h-5 w-auto"/>
                                </a>
                            </div>
                        </div>
                        <img class="object-cover w-auto h-[40rem] rounded-t-lg md:w-1/2 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="">
                    </div>
                </div>
            </section>
        </main>

        <footer class="px-32">

        </footer>
    </body>
</html>
