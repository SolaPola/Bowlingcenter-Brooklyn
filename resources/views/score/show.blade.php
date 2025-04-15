<!-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\score\show.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6 text-indigo-800 border-b pb-2">Score Details</h1>

                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-indigo-100">
                                <tr>
                                    <th class="py-3 px-6 border-b text-left font-semibold text-indigo-800">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 border-b text-lg font-medium">{{ $score->amount }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>


                    <div class="mt-6 flex justify-start">
                        <a href="{{ route('score.index') }}"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200 ease-in-out flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Back to Scores
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
