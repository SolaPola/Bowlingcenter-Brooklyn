<!-- filepath: c:\Users\solap\Herd\proefbowling\resources\views\score\show.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Score Details</h1>
                    
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $score->amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        <a href="{{ route('score.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back to Scores</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>