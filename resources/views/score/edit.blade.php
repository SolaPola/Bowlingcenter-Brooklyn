<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Score Bewerken') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg my-6">
                <div class="p-6">
                    @if(isset($score) && $score)
                        <form method="POST" action="{{ route('score.update', $score->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="firstName" class="block text-gray-700 text-sm font-bold mb-2">
                                    Voornaam:
                                </label>
                                <input type="text" name="firstName" id="firstName" 
                                    value="{{ old('firstName', $firstName) }}"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                
                                @error('firstName')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="lastName" class="block text-gray-700 text-sm font-bold mb-2">
                                    Achternaam:
                                </label>
                                <input type="text" name="lastName" id="lastName" 
                                    value="{{ old('lastName', $lastName) }}"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                
                                @error('lastName')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">
                                    Score:
                                </label>
                                <input type="number" name="amount" id="amount" 
                                    value="{{ old('amount', $score->amount) }}"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                
                                @error('amount')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="membershipType" class="block text-gray-700 text-sm font-bold mb-2">
                                    Lidmaatschap Type:
                                </label>
                                <select name="membershipType" id="membershipType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Basis" {{ old('membershipType', $membershipType) == 'Basis' ? 'selected' : '' }}>Basis</option>
                                    <option value="Premium" {{ old('membershipType', $membershipType) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                    <option value="VIP" {{ old('membershipType', $membershipType) == 'VIP' ? 'selected' : '' }}>VIP</option>
                                </select>
                                
                                @error('membershipType')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                                    Score Bijwerken
                                </button>
                                
                                <a href="{{ route('score.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                                    Terug naar Scores
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="bg-red-500 text-white p-4 rounded mb-4">
                            Score niet gevonden. <a href="{{ route('score.index') }}" class="underline font-bold">Terug naar scorelijst</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        h2 {
            color: #fff;
        }
    </style>
</x-app-layout>