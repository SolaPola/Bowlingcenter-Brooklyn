<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

    <!-- Header -->
    <header class="bg-yellow-400 shadow">
        <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Brooklyn Bowlingcenter</h1>

            @if (Route::has('login'))
                <nav class="-mx-3 flex flex-1 justify-end space-x-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Hero Section -->
<!-- Hero Section -->
<section class="py-20 bg-cover bg-center" style="background-image: url('{{ asset('img/bowlingimg.jpg') }}');">
    <div class="max-w-4xl mx-auto text-center px-4 bg-white bg-opacity-75 py-10 rounded-lg">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Welcome to the bowling paradise</h2>
        <p class="text-lg text-gray-700 mb-6">We have great bowling lanes HEHEHEHHEHE</p>
        <a href="#" class="inline-block bg-yellow-400 text-gray-900 font-semibold px-6 py-3 rounded-full shadow hover:bg-yellow-300 transition">Get Started</a>
    </div>
</section>

    <!-- Features -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2 text-yellow-500">Fast</h3>
                <p class="text-gray-600">Lightning-fast performance to keep you moving.</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2 text-yellow-500">Reliable</h3>
                <p class="text-gray-600">Always up, always running, always here for you.</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2 text-yellow-500">Secure</h3>
                <p class="text-gray-600">Your data is safe with us – always encrypted and protected.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-yellow-400 py-6 mt-20">
        <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
            &copy; 2025 MyWebsite. All rights reserved.
        </div>
    </footer>

</body>
</html>
