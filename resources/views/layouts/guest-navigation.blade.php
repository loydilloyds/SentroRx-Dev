<nav class="bg-srx-white shadow-md w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="shrink-0">
                <x-nav-link href="/" class="flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current" />
                </x-nav-link>
            </div>
            <div class="flex justify-between items-center gap-4">
                <x-nav-link :href="route('appointments')" class="nav">Appointments</x-nav-link>
                <x-nav-link href="" class="nav">Health Centers</x-nav-link>
                <x-nav-link :href="route('register')"
                            class="nav welcome-secondary-button">
                    Sign Up
                </x-nav-link>
                <x-nav-link :href="route('login')"
                            class="nav welcome-primary-button px-4">
                    Log In
                </x-nav-link>
            </div>
        </div>
    </div>
</nav>
