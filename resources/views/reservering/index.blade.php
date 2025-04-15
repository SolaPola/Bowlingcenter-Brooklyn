<x-app-layout>
<x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Overzicht bevestigde Reservering') }}
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