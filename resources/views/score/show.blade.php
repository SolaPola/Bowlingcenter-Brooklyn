<!-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\score\show.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Reservering Details</h2>
                        <a href="{{ route('score.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                            Terug naar overzicht
                        </a>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-gray-600 text-sm">Naam:</p>
                                <p class="text-gray-900 font-medium">{{ $score->Naam ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Datum:</p>
                                <p class="text-gray-900 font-medium">{{ $score->Datum ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Aantal Uren:</p>
                                <p class="text-gray-900 font-medium">{{ $score->AantalUren ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Begintijd:</p>
                                <p class="text-gray-900 font-medium">{{ $score->BeginTijd ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Eindtijd:</p>
                                <p class="text-gray-900 font-medium">{{ $score->EindTijd ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Aantal Volwassenen:</p>
                                <p class="text-gray-900 font-medium">{{ $score->AantalVolwassenen ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Aantal Kinderen:</p>
                                <p class="text-gray-900 font-medium">{{ $score->AantalKinderen ?? 'N/A' }}</p>
                            </div>

                            @if (isset($score->ScorePunten))
                                <div class="md:col-span-2">
                                    <p class="text-gray-600 text-sm">Score Punten:</p>
                                    <p class="text-gray-900 font-medium text-lg">{{ $score->ScorePunten }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
