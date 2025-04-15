<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Nieuwe Reservering') }}
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
                <a href="{{ route('reservations.index') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Terug naar Overzicht</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf
                        
                        <!-- Court Selection -->
                        <div class="mb-4">
                            <label for="courtId" class="block text-sm font-medium text-gray-700">Selecteer Baan</label>
                            <select name="courtId" id="courtId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Selecteer een baan</option>
                                @foreach ($courts as $court)
                                    <option value="{{ $court->id }}" {{ old('courtId') == $court->id ? 'selected' : '' }}>
                                        Baan {{ $court->number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('courtId')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Datum Selectie -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
                            <input type="date" name="date" id="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tijdvak Selectie -->
                        <div class="mb-4">
                            <label for="timeslotId" class="block text-sm font-medium text-gray-700">Selecteer Tijdvak</label>
                            <select name="timeslotId" id="timeslotId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Kies een tijdvak</option>
                                @foreach ($timeslots as $timeslot)
                                    <option value="{{ $timeslot->id }}" {{ old('timeslotId') == $timeslot->id ? 'selected' : '' }}>
                                        {{ $timeslot->startTime }} - {{ $timeslot->endTime }}
                                    </option>
                                @endforeach
                            </select>
                            @error('timeslotId')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability Status -->
                        <div id="availabilityStatus" class="mb-4 hidden">
                            <p class="text-sm font-medium text-gray-700">Beschikbaarheid:</p>
                            <div id="availabilityMessage" class="mt-1 p-2 rounded-md"></div>
                        </div>

                        <!-- Duur in Minuten -->
                        <div class="mb-4">
                            <label for="minutes" class="block text-sm font-medium text-gray-700">Duur (minuten)</label>
                            <select name="minutes" id="minutes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="30" {{ old('minutes') == 30 ? 'selected' : '' }}>30 minuten</option>
                                <option value="60" {{ old('minutes', 60) == 60 ? 'selected' : '' }}>1 uur</option>
                                <option value="90" {{ old('minutes') == 90 ? 'selected' : '' }}>1,5 uur</option>
                                <option value="120" {{ old('minutes') == 120 ? 'selected' : '' }}>2 uur</option>
                            </select>
                            @error('minutes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aantal Personen -->
                        <div class="mb-4">
                            <label for="numberOfPeople" class="block text-sm font-medium text-gray-700">Aantal Personen</label>
                            <input type="number" name="numberOfPeople" id="numberOfPeople" value="{{ old('numberOfPeople', 1) }}" min="1" max="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('numberOfPeople')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>In behandeling</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Bevestigd</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Extra Opmerkingen -->
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Extra Opmerkingen</label>
                            <textarea name="note" id="note" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('note') }}</textarea>
                            @error('note')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('reservations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Annuleren
                            </a>
                            <button type="submit" id="submitButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Reservering Aanmaken
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
    
    // Add JavaScript to check court availability
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const timeslotSelect = document.getElementById('timeslotId');
        const courtSelect = document.getElementById('courtId');
        const availabilityStatus = document.getElementById('availabilityStatus');
        const availabilityMessage = document.getElementById('availabilityMessage');
        const submitButton = document.getElementById('submitButton');
        
        function checkAvailability() {
            const date = dateInput.value;
            const timeslotId = timeslotSelect.value;
            
            if (!date || !timeslotId) {
                availabilityStatus.classList.add('hidden');
                return;
            }
            
            fetch(`/reservations/check-availability?date=${date}&timeslotId=${timeslotId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear existing options
                    while (courtSelect.options.length > 1) {
                        courtSelect.remove(1);
                    }
                    
                    // Update court availability and add options
                    let availableCourts = 0;
                    data.data.forEach(court => {
                        const option = new Option(`Baan ${court.number} (${court.status})`, court.id);
                        option.disabled = court.status !== 'Available';
                        courtSelect.add(option);
                        
                        if (court.status === 'Available') {
                            availableCourts++;
                        }
                    });
                    
                    availabilityStatus.classList.remove('hidden');
                    if (availableCourts > 0) {
                        availabilityMessage.textContent = `${availableCourts} banen beschikbaar voor deze datum en tijd.`;
                        availabilityMessage.classList.remove('bg-red-100', 'text-red-700');
                        availabilityMessage.classList.add('bg-green-100', 'text-green-700');
                        submitButton.disabled = false;
                    } else {
                        availabilityMessage.textContent = 'Geen banen beschikbaar voor deze datum en tijd.';
                        availabilityMessage.classList.remove('bg-green-100', 'text-green-700');
                        availabilityMessage.classList.add('bg-red-100', 'text-red-700');
                        submitButton.disabled = true;
                    }
                }
            })
            .catch(error => {
                console.error('Error checking availability:', error);
            });
        }
        
        dateInput.addEventListener('change', checkAvailability);
        timeslotSelect.addEventListener('change', checkAvailability);

        // Add form submission feedback
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (!dateInput.value || !timeslotSelect.value || !courtSelect.value) {
                e.preventDefault();
                alert('Vul alle verplichte velden in');
                return;
            }
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = 'Bezig met verwerken...';
            
            // Form will submit normally and redirect to index is handled by controller
        });
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