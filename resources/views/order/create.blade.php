<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-900 leading-tight">
            {{ __('Nieuwe Bestelling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('order.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="orderNumber" class="block text-gray-700 text-sm font-bold mb-2">Ordernummer:</label>
                            <input type="text" name="orderNumber" id="orderNumber" value="{{ old('orderNumber') }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="orderDate" class="block text-gray-700 text-sm font-bold mb-2">Datum:</label>
                            <input type="date" name="orderDate" id="orderDate" value="{{ old('orderDate', date('Y-m-d')) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="packageType" class="block text-gray-700 text-sm font-bold mb-2">Pakket Type:</label>
                            <select name="packageType" id="packageType" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Basic" {{ old('packageType') == 'Basic' ? 'selected' : '' }}>Basic</option>
                                <option value="Premium" {{ old('packageType') == 'Premium' ? 'selected' : '' }}>Premium</option>
                                <option value="VIP" {{ old('packageType') == 'VIP' ? 'selected' : '' }}>VIP</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Annuleren
                        </a>
                        <button type="submit" class="bg-yellow-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transform transition duration-300 hover:scale-105">
                            Toevoegen
                        </button>
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
