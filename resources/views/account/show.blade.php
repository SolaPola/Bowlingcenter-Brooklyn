<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Klantgegevens') }}
            </h2>
            <div>
                <a href="{{ route('accounts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600">
                    Terug naar overzicht
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6 p-6">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                            <h3 class="text-lg font-medium text-blue-800">Persoonlijke Informatie</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-gray-600 text-sm">Naam</p>
                                <p class="font-medium text-gray-800">{{ $account->fullName }}</p>
                            </div>
                            
                            <div>
                                <p class="text-gray-600 text-sm">Volwassen</p>
                                <p class="font-medium text-gray-800">{{ $account->isAdult }}</p>
                            </div>
                            
                            <div>
                                <p class="text-gray-600 text-sm">E-mail</p>
                                <p class="font-medium text-gray-800">{{ $account->emailAddress }}</p>
                            </div>
                            
                            <div>
                                <p class="text-gray-600 text-sm">Mobiel</p>
                                <p class="font-medium text-gray-800">{{ $account->mobileNumber ?? 'Niet beschikbaar' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('accounts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600">
                                Terug
                            </a>
                            <a href="{{ route('accounts.edit', $account->personId) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                                Bewerken
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    h2 {
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
