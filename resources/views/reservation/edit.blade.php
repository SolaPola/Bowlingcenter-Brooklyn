<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Reservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('reservation.update', $reservation->id) }}">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Court Selection -->
                        <div class="mb-4">
                            <label for="courtId" class="block text-sm font-medium text-gray-700">Select Court</label>
                            <select name="courtId" id="courtId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($courts as $court)
                                    <option value="{{ $court->id }}" {{ (old('courtId', $reservation->courtId) == $court->id) ? 'selected' : '' }}>
                                        {{ $court->name }} - {{ $court->description }}
                                    </option>
                                @endforeach
                            </select>
                            @error('courtId')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Selection -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $reservation->date) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time Slot Selection -->
                        <div class="mb-4">
                            <label for="timeslotId" class="block text-sm font-medium text-gray-700">Select Time Slot</label>
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
                            <label for="minutes" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                            <select name="minutes" id="minutes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="30" {{ (old('minutes', $reservation->minutes) == 30) ? 'selected' : '' }}>30 minutes</option>
                                <option value="60" {{ (old('minutes', $reservation->minutes) == 60) ? 'selected' : '' }}>1 hour</option>
                                <option value="90" {{ (old('minutes', $reservation->minutes) == 90) ? 'selected' : '' }}>1.5 hours</option>
                                <option value="120" {{ (old('minutes', $reservation->minutes) == 120) ? 'selected' : '' }}>2 hours</option>
                            </select>
                            @error('minutes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Number of People -->
                        <div class="mb-4">
                            <label for="numberOfPeople" class="block text-sm font-medium text-gray-700">Number of People</label>
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
                                <option value="pending" {{ (old('status', $reservation->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ (old('status', $reservation->status) == 'confirmed') ? 'selected' : '' }}>Confirmed</option>
                                <option value="canceled" {{ (old('status', $reservation->status) == 'canceled') ? 'selected' : '' }}>Canceled</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="note" id="note" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('note', $reservation->note) }}</textarea>
                            @error('note')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('reservation.show', $reservation->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Reservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
