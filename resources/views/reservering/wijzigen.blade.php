<x-app-layout>
<x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Bestaand baan wijzigen') }}
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
            </div>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="flex justify-end mb-4">
                        <form method="GET" action="{{ route('reservering.wijzigen') }}">
                            <label for="datum" class="mr-2 text-sm font-medium text-gray-700">Datum:</label>
                            <input type="date" id="datum" name="datum" value="{{ request('datum', date('Y-m-d')) }}" class="border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 px-3 py-2 text-sm">
                            <label for="status" class="ml-4 mr-2 text-sm font-medium text-gray-700">Status:</label>
                            <select id="status" name="status" class="border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 px-3 py-2 text-sm">
                                <option value="">Alle</option>
                                <option value="bevestigd" {{ request('status') == 'bevestigd' ? 'selected' : '' }}>Bevestigd</option>
                                <option value="geannuleerd" {{ request('status') == 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                            <button type="submit" class="ml-4 bg-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                Filteren
                            </button>
                        </form>
                    </div>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                <th class="py-4 px-6 text-left">Naam</th>
                                <th class="py-4 px-6 text-left">Reservering Datum</th>
                                <th class="py-4 px-6 text-center">Volwassen</th>
                                <th class="py-4 px-6 text-center">Kinderen</th>
                                <th class="py-4 px-6 text-center">Baan ID</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center">Wijzigen</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm font-light">
                            @forelse ($reserveringen as $reservering)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">
                                        {{ $reservering->Naam }}
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $reservering->Reserveringsdatum }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->Volwassenen }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->Kinderen ?? 0 }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->BaanNummer }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->Status }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-3 px-6 text-center text-gray-500">
                                        Geen reserveringen gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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