<!-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\score\index.blade.php -->
<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Score Overview</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-white text-gray-800">

        <!-- Header -->
        <header class="bg-yellow-400 shadow">
            <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Reserveringen van Mazin Jamil</h1>
            </div>
        </header>

        <!-- Create Button -->
        <div class="flex justify-center mt-6">
            <a href="{{ route('score.create') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md">create Score</a>
        </div>

        <div class="flex justify-center mt-6">
            <a href="{{ route('score.create') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md">Edit Score</a>
        </div>

        <!-- Table -->
        <div class="container mx-auto mt-8">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Naam</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Datum</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Aantal Uren</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Begintijd</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Eindtijd</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Aantal Volwassenen</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Aantal Kinderen</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Wijzigen</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Score punten</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($scoreOverview as $score)
                        <tr>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->Naam }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->Datum }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->AantalUren }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->BeginTijd }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->EindTijd }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->AantalVolwassenen }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $score->AantalKinderen ?? 0 }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                <a href="{{ route('score.edit', $score->ReservationId) }}"
                                    class="text-blue-500">🖊️</a>
                            </td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                <a href="{{ route('score.show', $score->ReservationId) }}"
                                    class="text-blue-500">ⓘ</a>
                            </td>



                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700 text-center text-red-500">
                                No Scores Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
