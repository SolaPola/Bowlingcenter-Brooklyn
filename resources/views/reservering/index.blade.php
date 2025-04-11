<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Bevestigde Reservering') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('reservering.index') }}" class="mb-4 flex items-center">
                        <label for="datum" class="mr-2 text-sm font-medium text-gray-700">Datum:</label>
                        <input type="date" id="datum" name="datum" value="{{ $datum }}" class="border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 px-3 py-2 text-sm">
                        <button type="submit" class="ml-4 bg-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                            Tonen
                        </button>
                    </form>
                    @if (count($reserveringen) > 0)
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                    <th class="py-4 px-6 text-left">Naam</th>
                                    <th class="py-4 px-6 text-left">Reservering Datum</th>
                                    <th class="py-4 px-6 text-left">Uren</th>
                                    <th class="py-4 px-6 text-center">Volwassen</th>
                                    <th class="py-4 px-6 text-center">Kinderen</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 text-sm font-light">
                                @foreach ($reserveringen as $reservering)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap font-medium">
                                            {{ $reservering->Naam }}
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ $reservering->Datum }}</td>
                                        <td class="py-3 px-6 text-left">{{ $reservering->AantalUren }}</td>
                                        <td class="py-3 px-6 text-center">{{ $reservering->AantalVolwassen }}</td>
                                        <td class="py-3 px-6 text-center">{{ $reservering->AantalKinderen ?? 0 }}</td>
                                        <td class="py-3 px-6 text-center">{{ $reservering->ReserveringStatus }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 text-center mt-4">
                            Er is geen reserveringsinformatie beschikbaar voor deze geselecteerde datum.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
