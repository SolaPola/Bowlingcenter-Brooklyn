<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservering Aanpassen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="mb-4 text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('updatebaan', ['id' => $id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="naam" class="block text-sm font-medium text-gray-700">Naam:</label>
                            <input type="text" id="naam" value="{{ $reservering->Naam }}" disabled class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="datum" class="block text-sm font-medium text-gray-700">Datum:</label>
                            <input type="date" id="datum" value="{{ $reservering->Reserveringsdatum }}" disabled class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="baanId" class="block text-sm font-medium text-gray-700">Baannummer:</label>
                            <select id="baanId" name="baanId" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 px-3 py-2 text-sm">
                                @foreach ($banen as $baan)
                                    <option value="{{ $baan->id }}" {{ $baan->id == $reservering->BaanNummer ? 'selected' : '' }}>
                                        Baan {{ $baan->number }} {{ $baan->status == 'Available' ? '(Beschikbaar)' : '(Gereserveerd)' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                            <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 px-3 py-2 text-sm">
                                <option value="bevestigd" {{ $reservering->Status == 'bevestigd' ? 'selected' : '' }}>Bevestigd</option>
                                <option value="geannuleerd" {{ $reservering->Status == 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                Opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
