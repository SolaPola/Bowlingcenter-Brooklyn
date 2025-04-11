<!-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\score\show.blade.php -->
<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Score Details</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-white text-gray-800">

        <!-- Header -->
        <header class="bg-yellow-400 shadow">
            <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Score Details</h1>
            </div>
        </header>

        <!-- Details -->
        <div class="container mx-auto mt-8">
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Details for Reservation ID: {{ $score->id }}</h2>
                <p><strong>Naam:</strong> {{ $score->Naam }}</p>
                <p><strong>Datum:</strong> {{ $score->Datum }}</p>
                <p><strong>Aantal Uren:</strong> {{ $score->AantalUren }}</p>
                <p><strong>Begin Tijd:</strong> {{ $score->BeginTijd }}</p>
                <p><strong>Eind Tijd:</strong> {{ $score->EindTijd }}</p>
                <p><strong>Aantal Volwassenen:</strong> {{ $score->AantalVolwassenen }}</p>
                <p><strong>Aantal Kinderen:</strong> {{ $score->AantalKinderen ?? 0 }}</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-center mt-6">
            <a href="{{ route('score.index') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md">Back to Overview</a>
        </div>

        <!-- Footer -->
        <footer class="bg-yellow-400 py-6 mt-20">
            <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
                &copy; 2025 MyWebsite. All rights reserved.
            </div>
        </footer>

    </body>

    </html>
</x-app-layout>