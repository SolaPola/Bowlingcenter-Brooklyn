<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Reserveringen') }}
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
                <a href="{{ route('reservations.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Nieuwe Reservering</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Reservations List -->
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (count($reservations) > 0)
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                        <th class="py-4 px-6 text-left">Datum</th>
                                        <th class="py-4 px-6 text-left">Tijd</th>
                                        <th class="py-4 px-6 text-left">Baan</th>
                                        <th class="py-4 px-6 text-left">Duur</th>
                                        <th class="py-4 px-6 text-center">Status</th>
                                        <th class="py-4 px-6 text-center">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 text-sm font-light">
                                    @foreach ($reservations as $reservation)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $reservation->date }}</td>
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ date('H:i', strtotime($reservation->startTime)) }}</td>
                                            <td class="py-3 px-6 text-left">{{ $reservation->courtNumber }}</td>
                                            <td class="py-3 px-6 text-left">{{ $reservation->minutes }} minuten</td>
                                            <td class="py-3 px-6 text-center">
                                                @if($reservation->status === 'Betaald')
                                                    <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs font-medium">Bevestigd</span>
                                                @elseif($reservation->status === 'In behandeling')
                                                    <span class="bg-yellow-400 text-white py-1 px-3 rounded-full text-xs font-medium">In behandeling</span>
                                                @else
                                                    <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs font-medium">Geannuleerd</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center space-x-4">
                                                <a href="{{ route('reservations.show', $reservation->id) }}" class="text-blue-600 hover:text-blue-800 transition duration-300">ⓘ</a>
                                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="text-yellow-500 hover:text-yellow-700 transition duration-300">✎</a>
                                                <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}" class="inline-block" onsubmit="return confirm('Weet u zeker dat u deze reservering wilt annuleren?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300">🗑️</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Pagination Links -->
                            <div class="px-6 py-4">
                                {{ $reservations->links() }}
                            </div>
                        @else
                            <div class="p-4">
                                <p class="bg-red-500 text-white p-4 rounded mb-4">Geen reserveringen gevonden.</p>
                            </div>
                        @endif
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
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    
    .pagination > div {
        display: flex;
        align-items: center;
    }
    
    .pagination span.px-4, .pagination a.px-4 {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        margin: 0 0.25rem;
    }
    
    .pagination span.bg-blue-50 {
        background-color: #3b82f6;
        color: white;
    }
    
    .pagination a:hover {
        background-color: #f3f4f6;
    }
</style>
