{{-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\order\index.blade.php --}}
<x-app-layout>

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
    
        
     
    
        <!-- Footer -->
        <footer class="bg-yellow-400 py-6 mt-20">
            <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
                &copy; 2025 MyWebsite. All rights reserved.
            </div>
        </footer>
    
    </body>
    </html>
    




</x-app-layout>