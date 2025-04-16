<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welkomstkaart -->
            <div class="bg-white shadow-lg rounded-2xl p-8 mb-8">
                <h3 class="text-3xl font-bold text-yellow-500 mb-2">🎳 Dashboard</h3>
                <p class="text-gray-700 text-lg">Je bent succesvol ingelogd op het Brooklyn Bowlingcenter portaal.</p>
            </div>

            <!-- Snelle Acties -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-yellow-100 p-6 rounded-xl shadow hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">📅 Nieuwe reservering</h4>
                    <p class="text-gray-700 mb-4">Boek snel een baan voor jou en je vrienden.</p>
                    <a href="{{ route('reservations.create') }}" class="inline-block bg-yellow-400 text-gray-900 font-medium px-4 py-2 rounded-md hover:bg-yellow-300 transition">
                        Reserveer Nu
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition border">
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">📊 Mijn gegevens</h4>
                    <p class="text-gray-700 mb-4">Bekijk en beheer je profiel of eerdere reserveringen.</p>
                    <a href="{{ route('profile.edit') }}" class="inline-block bg-gray-800 text-white font-medium px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        Profiel beheren
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
