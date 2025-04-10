<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservation Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Reservation #{{ $reservation->id }}</h3>
                        <div>
                            <a href="{{ route('reservation.edit', $reservation->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                Edit
                            </a>
                            <a href="{{ route('reservation.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg shadow-inner mb-6">
                        <h4 class="text-lg font-medium mb-4">Reservation Details</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Status</p>
                                <p class="mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                           ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Date</p>
                                <p class="mt-1">{{ $reservation->date }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Time Slot</p>
                                <p class="mt-1">{{ $reservation->timeslot->startTime }} - {{ $reservation->timeslot->endTime }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Duration</p>
                                <p class="mt-1">{{ $reservation->minutes }} minutes</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Court</p>
                                <p class="mt-1">{{ $reservation->court->name }} ({{ $reservation->court->description }})</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600">Number of People</p>
                                <p class="mt-1">{{ $reservation->numberOfPeople }}</p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-600">Notes</p>
                                <p class="mt-1">{{ $reservation->note ?? 'No notes provided' }}</p>
                            </div>
                        </div>
                    </div>

                    @if(count($reservation->orders) > 0)
                    <div class="mt-8">
                        <h4 class="text-lg font-medium mb-4">Related Orders</h4>
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order #</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation->orders as $order)
                                <tr>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $order->orderNumber }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $order->orderDate }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">
                                        {{ $order->isActive ? 'Active' : 'Inactive' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <div class="mt-8">
                        <form method="POST" action="{{ route('reservation.destroy', $reservation->id) }}" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancel Reservation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
