<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Reserveringsdetails') }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
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
                <a href="{{ route('reservations.index') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Terug naar Lijst</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Reservering #{{ $reservation->id }}</h3>
                        <div>
                            <a href="{{ route('reservations.edit', $reservation->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                Bewerken
                            </a>
                            <a href="{{ route('reservations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Terug naar Lijst
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg shadow-inner mb-6">
                        <h4 class="text-lg font-medium mb-4">Reserveringsdetails</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Status</p>
                                <p class="mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                           ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ $reservation->status === 'confirmed' ? 'Bevestigd' : 
                                           ($reservation->status === 'pending' ? 'In behandeling' : 
                                           'Geannuleerd') }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Datum</p>
                                <p class="mt-1">{{ $reservation->date }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Tijdslot</p>
                                <p class="mt-1">{{ $reservation->timeslot->startTime }} - {{ $reservation->timeslot->endTime }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Duur</p>
                                <p class="mt-1">{{ $reservation->minutes }} minuten</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Baan</p>
                                <p class="mt-1">{{ $reservation->court->name }} ({{ $reservation->court->description }})</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Aantal Personen</p>
                                <p class="mt-1">{{ $reservation->numberOfPeople }}</p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-600">Opmerkingen</p>
                                <p class="mt-1">{{ $reservation->note ?? 'Geen opmerkingen' }}</p>
                            </div>
                        </div>
                    </div>

                    @if(count($reservation->orders) > 0)
                    <div class="mt-8">
                        <h4 class="text-lg font-medium mb-4">Gerelateerde Bestellingen</h4>
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bestelling #</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Datum</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation->orders as $order)
                                <tr>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $order->orderNumber }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $order->orderDate }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">
                                        {{ $order->isActive ? 'Actief' : 'Inactief' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <div class="mt-8">
                        <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}" onsubmit="return confirm('Weet je zeker dat je deze reservering wilt annuleren?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Reservering Annuleren
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen reserveringen gevonden. Probeer het later opnieuw.</p>
    </div>
</x-app-layout>

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
