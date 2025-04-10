{{-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\order\index.blade.php --}}
<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Homepage</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-white text-gray-800">

        <!-- Header -->
        <header class="bg-yellow-400 shadow">
            <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Order overview</h1>
            </div>
        </header>

        {{-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\order\index.blade.php --}}
        <div class="flex justify-center mt-6">
            <a href="{{ route('order.create') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md">Create
            Booking</a>
        </div>

        <div class="container mx-auto mt-8">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Order Number</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Order Date</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Package Type</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Edit</th>
                        <th
                            class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                            Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $order->orderNumber }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $order->orderDate }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                {{ $order->packageType }}</td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                <a href="{{ route('order.edit', $order->id) }}" class="text-blue-500">Edit</a>
                            </td>
                            <td class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700">
                                <button type="button" class="text-red-500"
                                    onclick="showDeleteModal({{ $order->id }})">Delete</button>
                            </td>
                        </tr>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10"
                                class="px-4 py-2 border-b border-r border-gray-300 dark:border-gray-700 text-center text-red-500">
                                No Order available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300">Confirm Delete</h2>
                    <p class="my-4 text-gray-500 dark:text-gray-400">Are you sure you want to delete this item?</p>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="mt-6 px-4 py-2 bg-gray-600 text-white rounded-lg"
                            onclick="hideDeleteModal()">Cancel</button>
                        <button type="submit" class="mt-6 px-4 py-2 bg-red-600 text-white rounded-lg">Delete</button>
                    </form>
                </div>
            </div>

            <!-- Script to show and hide the delete modal -->
<script>
    function showDeleteModal(id) {
        var action = '{{ route('order.destroy', ':id') }}';
        action = action.replace(':id', id);
        document.getElementById('deleteForm').action = action;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Hide success message after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    });
</script>
















        </div>
        <!-- Footer -->
        <footer class="bg-yellow-400 py-6 mt-20">
            <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
                &copy; 2025 MyWebsite. All rights reserved.
            </div>
        </footer>

    </body>

    </html>





</x-app-layout>
