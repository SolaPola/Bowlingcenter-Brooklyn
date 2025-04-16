{{-- filepath: resources/views/score/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Reserveringen per klant') }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 dark:bg-gray-800">
                <label class="flex items-center">
                    <span class="mr-2 text-white-900 toon">Toon Gegevens</span>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </label>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Scores List -->
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (count($scores) > 0)
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                        <th class="py-4 px-6 text-left">Naam</th>
                                        <th class="py-4 px-6 text-left">Datum</th>
                                        <th class="py-4 px-6 text-left">Aantal Uren</th>
                                        <th class="py-4 px-6 text-left">Begin</th>
                                        <th class="py-4 px-6 text-left">Eind</th>
                                        <th class="py-4 px-6 text-left">Aantal Volwassenen</th>
                                        <th class="py-4 px-6 text-left">Aantal Kinderen</th>
                                        <th class="py-4 px-6 text-center">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 text-sm font-light">
                                    @forelse ($scores as $score)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $score->Naam }}</td>
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $score->Datum }}</td>
                                            <td class="py-3 px-6 text-left">{{ $score->AantalUren }}</td>
                                            <td class="py-3 px-6 text-left">{{ date('H:i', strtotime($score->BeginTijd)) }}</td>
                                            <td class="py-3 px-6 text-left">{{ date('H:i', strtotime($score->EindTijd)) }}</td>
                                            <td class="py-3 px-6 text-left">{{ $score->AantalVolwassenen }}</td>
                                            <td class="py-3 px-6 text-left">{{ $score->AantalKinderen ?? 0 }}</td>
                                            <td class="py-3 px-6 text-center space-x-4">
                                                <a href="{{ route('score.edit', $score->ReservationId) }}" class="text-yellow-500 hover:text-yellow-700 transition duration-300">✎</a>
                                                <a href="{{ route('score.show', $score->ReservationId) }}" class="text-blue-600 hover:text-blue-800 transition duration-300">ⓘ</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-4 py-2 text-center">
                                                <p class="bg-red-500 text-white p-4 rounded mb-4">Geen scores beschikbaar.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <div class="p-4">
                                <p class="bg-red-500 text-white p-4 rounded mb-4">Geen scores beschikbaar.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen scores gevonden. Probeer het later opnieuw.</p>
    </div>

    <script>
        document.getElementById('dataToggle').addEventListener('change', function() {
            const dataContainer = document.getElementById('dataContainer');
            const errorContainer = document.getElementById('errorContainer');
            if (this.checked) {
                dataContainer.classList.remove('hidden');
                errorContainer.classList.add('hidden');
            } else {
                dataContainer.classList.add('hidden');
                errorContainer.classList.remove('hidden');
            }
        });
    </script>

    <style>
        h2 {
            color: #fff;
        }

        .toon {
            color: #fff;
        }

        .toggle-checkbox:checked {
            right: 0;
            border-color: #38A169;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #38A169;
        }
    </style>
</x-app-layout>
