<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Overzicht Klanten') }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                <form action="{{ route('accounts.index') }}" method="GET" class="flex items-center space-x-4">
                    <div class="flex items-center space-x-4 bg-white p-2 rounded-lg shadow-md">
                       <input type="text" 
                               name="end_date" 
                               class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" 
                               placeholder="Kies einddatum"
                               value="{{ request('end_date', date('Y-m-d')) }}"
                               id="end_date">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                        Maak selectie
                    </button>
                </form>
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

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Accounts List -->
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        
                        @if (session('info'))
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('info') }}</span>
                            </div>
                        @endif
                        
                        @if(request('start_date') || request('end_date'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">
                                    Toont klanten geregistreerd 
                                    {{ request('start_date') ? 'van ' . request('start_date') : '' }} 
                                    tot {{ request('end_date', date('Y-m-d')) }}
                                </span>
                            </div>
                        @endif

                        <!-- Table structure with account data -->
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                    <th class="py-4 px-6 text-left">Naam</th>
                                    <th class="py-4 px-6 text-left">Mobiel</th>
                                    <th class="py-4 px-6 text-left">E-mail</th>
                                    <th class="py-4 px-6 text-center">Volwassen</th>
                                    <th class="py-4 px-6 text-center">Datum</th>
                                    <th class="py-4 px-6 text-center">Wijzigen</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 text-sm font-light">
                                @if(isset($accounts) && count($accounts) > 0)
                                    @foreach($accounts as $account)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left">{{ $account->fullName }}</td>
                                        <td class="py-3 px-6 text-left">{{ $account->mobileNumber ?? 'N/A' }}</td>
                                        <td class="py-3 px-6 text-left">{{ $account->emailAddress }}</td>
                                        <td class="py-3 px-6 text-center">{{ $account->isAdult }}</td>
                                        <td class="py-3 px-6 text-center">{{ $account->createdAt ?? 'N/A' }}</td> <!-- Ensure this field is accessed -->
                                        <td class="py-3 px-6 text-center">
                                            <a href="{{ route('accounts.show', $account->personId) }}" 
                                            class="text-yellow-500 hover:text-yellow-700 transition duration-300">✎</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr class="border-b border-gray-200">
                                        <td colspan="6" class="py-4 px-6 text-center">Geen account gegevens beschikbaar</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div class="px-6 py-4">
                            @if(isset($accounts))
                                {{ $accounts->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Er is geen informatie beschikbaar voor deze geselecteerde datum</p>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr datepickers
    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
    
    flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        allowInput: true,
        defaultDate: "{{ request('end_date', date('Y-m-d')) }}"
    });

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

    /* Flatpickr customization */
    .flatpickr-calendar {
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
