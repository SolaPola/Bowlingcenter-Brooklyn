<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Bestellingen Overzicht') }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                <a href="{{ route('order.create') }}" class="bg-yellow-500 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-600 transform hover:scale-105">
                    Nieuwe Bestellingen
                </a>
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
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                @if (session('success'))
                    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                <th class="py-4 px-6 text-left">Ordernummer</th>
                                <th class="py-4 px-6 text-left">Datum</th>
                                <th class="py-4 px-6 text-center">Pakket</th>
                                <th class="py-4 px-6 text-right">Bewerken</th>
                                <th class="py-4 px-6 text-right">Verwijderen</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm font-light">
                            @forelse ($orders as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6">{{ $order->orderNumber }}</td>
                                    <td class="py-3 px-6">{{ $order->orderDate }}</td>
                                    <td class="py-3 px-6 text-center">{{ $order->packageType }}</td>
                                    <td class="py-3 px-6 text-right">
                                        <a href="{{ route('order.edit', $order->id) }}" class="text-yellow-500 hover:text-yellow-700 transition duration-300">✎</a>
                                    </td>
                                    <td class="py-3 px-6 text-right">
                                        <button type="button" class="text-red-500 hover:text-red-700 transition duration-300"
                                            onclick="showDeleteModal({{ $order->id }})">🗑️</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-6 text-center text-red-500">Geen orders gevonden.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-xl font-semibold text-gray-800">Weet je het zeker?</h2>
            <p class="text-gray-600 mt-2">Deze order zal permanent worden verwijderd.</p>
            <form id="deleteForm" method="POST" class="mt-4 flex justify-center space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" onclick="hideDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Annuleer</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Verwijder</button>
            </form>
        </div>
    </div>

    <!-- Error Container for when toggle is off -->
    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Er is geen bestellingen beschikbaar, probeer later opnieuw</p>
    </div>

    <script>
        function showDeleteModal(id) {
            const action = '{{ route('order.destroy', ':id') }}'.replace(':id', id);
            document.getElementById('deleteForm').action = action;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 5000);

            // Add toggle functionality
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
</x-app-layout>
