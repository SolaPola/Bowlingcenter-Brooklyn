
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
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                <th class="py-4 px-6 text-left">Naam</th>
                                <th class="py-4 px-6 text-left">Reservering Datum</th>
                                <th class="py-4 px-6 text-center">Volwassen</th>
                                <th class="py-4 px-6 text-center">Kinderen</th>
                                <th class="py-4 px-6 text-center">Baan ID</th>
                                <th class="py-4 px-6 text-center">Wijzigen</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm font-light">
                            @forelse ($reserveringen as $reservering)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">
                                        {{ $reservering->Naam }}
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $reservering->Datum }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->AantalVolwassen }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->AantalKinderen ?? 0 }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->BaanId }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <a href="{{ route('editbaan', ['id' => $reservering->BaanId]) }}" class="text-blue-500 hover:underline">
                                            ✎
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-6 text-center text-gray-500">
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