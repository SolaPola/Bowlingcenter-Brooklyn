<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('klant Details') }}
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
                        
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif
                        
                        <form action="{{ route('accounts.update', $account->personId) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label for="firstName" class="block text-gray-700 text-sm font-bold mb-2">Voornaam</label>
                                    <input type="text" name="firstName" id="firstName" value="{{ $account->firstName }}" 
                                           class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full p-2">
                                    @error('firstName')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="infix" class="block text-gray-700 text-sm font-bold mb-2">Tussenvoegsel</label>
                                    <input type="text" name="infix" id="infix" value="{{ $account->infix ?? '' }}" 
                                           class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full p-2">
                                    @error('infix')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="lastName" class="block text-gray-700 text-sm font-bold mb-2">Achternaam</label>
                                    <input type="text" name="lastName" id="lastName" value="{{ $account->lastName }}" 
                                           class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full p-2">
                                    @error('lastName')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="emailAddress" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                                    <input type="email" name="emailAddress" id="emailAddress" value="{{ $account->emailAddress }}" 
                                           class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full p-2">
                                    @error('emailAddress')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="mobileNumber" class="block text-gray-700 text-sm font-bold mb-2">Mobiel</label>
                                    <input type="text" name="mobileNumber" id="mobileNumber" value="{{ $account->mobileNumber }}" 
                                           class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full p-2">
                                    @error('mobileNumber')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4 flex items-center">
                                    <input type="checkbox" name="isAdult" id="isAdult" {{ $account->isAdult ? 'checked' : '' }} 
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 mr-2">
                                    <label for="isAdult" class="text-gray-700 text-sm font-bold">Volwassen</label>
                                    @error('isAdult')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-4 mt-6">
                                <a href="{{ route('accounts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600">
                                    Annuleren
                                </a>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                                    Wijzigen
                                </button>
                            </div>
                        </form>
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
