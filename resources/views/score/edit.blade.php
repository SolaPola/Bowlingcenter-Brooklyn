
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Score') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if(isset($score) && $score)
                            <form method="POST" action="{{ route('score.update', $score->id) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">
                                        Amount:
                                    </label>
                                    <input type="number" name="amount" id="amount" 
                                        value="{{ old('amount', $score->amount) }}"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    
                                    @error('amount')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Update Score
                                    </button>
                                    
                                    <a href="{{ route('score.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="text-red-500">
                                Score not found. <a href="{{ route('score.index') }}" class="text-blue-500 hover:text-blue-800">Return to scores list</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>