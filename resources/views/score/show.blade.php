<x-app-layout>
    <x-slot name="header">me="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">lex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Score Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">x-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg my-6">y-6">
                <div class="p-6">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm mb-6">g-gray-50 p-6 rounded-lg shadow-sm mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">ay-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">text-gray-800 uppercase text-sm font-medium leading-normal">
                                    <th class="py-3 px-6 text-left">Veld</th>
                                    <th class="py-3 px-6 text-left">Waarde</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 text-sm font-light">lass="text-gray-800 text-sm font-light">
                                <tr class="border-b border-gray-200 hover:bg-gray-50">-gray-50">
                                    <td class="py-3 px-6 text-left font-medium">Score Hoeveelheid</td>Amount</td>
                                    <td class="py-3 px-6 text-left">{{ $score->amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-start">                    <div class="mt-6 flex justify-start">
                        <a href="{{ route('score.index') }}"}}"
                            class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition duration-200 ease-in-out flex items-center"> hover:bg-yellow-600 text-white rounded-md transition duration-200 ease-in-out flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"nodd"
                                    d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Terug naar Scoreso Scores
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>    <style>
        h2 {{
            color: #fff;color: #fff;
        </style>
</x-app-layout>le>
