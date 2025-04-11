<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bestaand Baan Wijzigen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                <th class="py-4 px-6 text-left">Naam</th>
                                <th class="py-4 px-6 text-left">Reservering Datum</th>
                                <th class="py-4 px-6 text-center">Volwassen</th>
                                <th class="py-4 px-6 text-center">Kinderen</th>
                                <th class="py-4 px-6 text-center">Baan ID</th>
                                <th class="py-4 px-6 text-center">Wijzigen</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm font-light">
                            @forelse ($reserveringen as $reservering)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">
                                        {{ $reservering->Naam }}
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $reservering->Datum }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->AantalVolwassen }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->AantalKinderen ?? 0 }}</td>
                                    <td class="py-3 px-6 text-center">{{ $reservering->BaanId }}</td>
                                    <td class="py-3 px-6 text-center">
                                        ✎
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-6 text-center text-gray-500">
                                        Geen reserveringen gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
