<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Reservering Bewerken') }}
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
                <a href="{{ route('reservations.index', $reservation->id) }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Terug naar lijst</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('reservations.update', ['id' => $reservation->id, 'redirect' => 'index']) }}">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Court Selection -->
                        <div class="mb-4">
                            <label for="courtId" class="block text-sm font-medium text-gray-700">Selecteer Baan</label>
                            <select name="courtId" id="courtId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($courts as $court)
                                    <option value="{{ $court->id }}" {{ (old('courtId', $reservation->courtId) == $court->id) ? 'selected' : '' }}>
                                        {{ $court->number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('courtId')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Selection -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $reservation->date) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time Slot Selection -->
                        <div class="mb-4">
                            <label for="timeslotId" class="block text-sm font-medium text-gray-700">Selecteer Tijdslot</label>
                            <select name="timeslotId" id="timeslotId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($timeslots as $timeslot)
                                    <option value="{{ $timeslot->id }}" {{ (old('timeslotId', $reservation->timeslotId) == $timeslot->id) ? 'selected' : '' }}>
                                        {{ $timeslot->startTime }} - {{ $timeslot->endTime }}
                                    </option>
                                @endforeach
                            </select>
                            @error('timeslotId')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration in Minutes -->
                        <div class="mb-4">
                            <label for="minutes" class="block text-sm font-medium text-gray-700">Duur (minuten)</label>
                            <select name="minutes" id="minutes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="30" {{ (old('minutes', $reservation->minutes) == 30) ? 'selected' : '' }}>30 minuten</option>
                                <option value="60" {{ (old('minutes', $reservation->minutes) == 60) ? 'selected' : '' }}>1 uur</option>
                                <option value="90" {{ (old('minutes', $reservation->minutes) == 90) ? 'selected' : '' }}>1,5 uur</option>
                                <option value="120" {{ (old('minutes', $reservation->minutes) == 120) ? 'selected' : '' }}>2 uur</option>
                            </select>
                            @error('minutes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Number of People -->
                        <div class="mb-4">
                            <label for="numberOfPeople" class="block text-sm font-medium text-gray-700">Aantal Personen</label>
                            <input type="number" name="numberOfPeople" id="numberOfPeople" value="{{ old('numberOfPeople', $reservation->numberOfPeople) }}" min="1" max="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('numberOfPeople')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="pending" {{ (old('status', $reservation->status) == 'pending') ? 'selected' : '' }}>In behandeling</option>
                                <option value="confirmed" {{ (old('status', $reservation->status) == 'confirmed') ? 'selected' : '' }}>Bevestigd</option>
                                <option value="canceled" {{ (old('status', $reservation->status) == 'canceled') ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Extra Opmerkingen</label>
                            <textarea name="note" id="note" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('note', $reservation->note) }}</textarea>
                            @error('note')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('reservations.show', $reservation->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Annuleren
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Bijwerken
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen reserveringen gevonden. Probeer het later opnieuw.</p>
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
</style>