<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Nieuwe Score Toevoegen') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg my-6 p-6">
                <form action="{{ route('score.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700">Voornaam</label>
                        <input type="text" name="firstName" id="firstName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('firstName')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Achternaam</label>
                        <input type="text" name="lastName" id="lastName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('lastName')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Score</label>
                        <input type="number" name="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('amount')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="membershipType" class="block text-sm font-medium text-gray-700">Lidmaatschap Type</label>
                        <select name="membershipType" id="membershipType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Basis">Basis</option>
                            <option value="Premium">Premium</option>
                            <option value="VIP">VIP</option>
                        </select>
                        @error('membershipType')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                            Toevoegen
                        </button>
                        <a href="{{ route('score.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                            Terug naar Scores
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        h2 {
            color: #fff;
        }
    </style>
</x-app-layout>
