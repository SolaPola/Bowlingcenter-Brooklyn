<x-app-layout>

    {{-- title on the top of the screen --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            Account overzicht
        </h2>
    </x-slot>

    
    @if (session('success'))

    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-3/4 m-auto text-center my-6" role="alert">
        <h3 class="block sm:inline">{{ session('success') }}</h3>
       
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-3/4 bg-white dark:bg-gray-800 m-auto mt-5 mb-5 text-white">
            <thead>
                <tr>
                    <th
                        class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4  tracking-wider">
                        Gebruikersnaam</th>
                    <th
                        class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                        Rol</th>
                    <th
                        class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                        geborte datum</th>
                    <th
                        class="px-4 py-2 border-b-2 border-r border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                        Wijzigen</th>
                    <th
                        class="px-4 py-2 border-b-2 border-gray-300 dark:border-gray-700 text-left leading-4 tracking-wider">
                        Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                {{-- if statement that checks if the array is empty and gives an message to the user if it is--}}
                @if($users->isEmpty())
                <tr class="bg-white dark:bg-gray-800">
                    <td class="px-4 py-2 border-b border-gray-300 dark:border-gray-700 text-white bg-red-700 text-center" colspan="5">Geen
                        resultaten gevonden, probeer het later opnieuw.</td>
                </tr>
                @else
                {{-- shows the data of the given array --}}
                @foreach($users as $user)
                <tr class="bg-white dark:bg-gray-800">
                    <td class="px-4 py-2 border-b border-gray-300 dark:border-gray-700  border-r">{{ $user->Username }}
                    </td>
                    <td class="px-4 py-2 border-b border-gray-300 dark:border-gray-700  border-r">{{ $user->role }}
                    </td>
                    <td class="px-4 py-2 border-b border-gray-300 dark:border-gray-700  border-r">{{ $user->birth_date  }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 dark:border-gray-700 text-white border-r"><a href=""
                            class="bg-green-700 p-1 rounded">Wijzigen</a></td>
                    <td class="px-4 py-2 border-b border-gray-300 dark:border-gray-700 text-white"><a href=""
                            class="bg-red-700 p-1 rounded">Verwijderen</a></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="m-auto mt-5 mb-5 w-3/4">
            {{-- pagination buttons --}}
            {{$users->links() }}
        </div>
        <div class="w-full justify-center flex my-6">
            {{-- button to create a new user --}}
            <a href="{{ route('users.create') }}"
                class="bg-blue-700 text-white p-2 rounded hover:bg-blue-800 dark:hover:bg-blue-900">Nieuwe
                account</a>
            
        </div>
    </div>



</x-app-layout>