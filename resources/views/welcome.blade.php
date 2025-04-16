<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Brooklyn Bowlingcenter | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

<!-- Header -->
<header class="bg-yellow-400 shadow">
    <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Brooklyn Bowlingcenter</h1>

        @if (Route::has('login'))
            <nav class="flex space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-900 bg-white rounded-md hover:bg-gray-100 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-900 bg-white rounded-md hover:bg-gray-100 transition">
                        Inloggen
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-900 bg-white rounded-md hover:bg-gray-100 transition">
                            Registreren
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</header>

<!-- Hero Sectie -->
<section class="relative py-24 bg-cover bg-center" style="background-image: url('{{ asset('img/bowlingimg.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative max-w-4xl mx-auto text-center px-4 text-white">
        <h2 class="text-4xl font-bold mb-4">Welkom bij hét bowlingparadijs van Brooklyn</h2>
        <p class="text-lg mb-6">Ontdek onze moderne banen, gezellige sfeer en topservice voor jong en oud.</p>
        <a href="{{ route('reservations.create') }}" class="inline-block bg-yellow-400 text-gray-900 font-semibold px-6 py-3 rounded-full shadow hover:bg-yellow-300 transition">
            Reserveer Nu
        </a>
    </div>
</section>

<!-- Kenmerken -->
<section class="py-16">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2 text-yellow-500">Snel</h3>
            <p class="text-gray-600">Razendsnelle service zodat je meteen kunt beginnen met bowlen.</p>
        </div>
        <div class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2 text-yellow-500">Betrouwbaar</h3>
            <p class="text-gray-600">Altijd open, altijd gezellig – jouw vaste plek voor een leuke avond.</p>
        </div>
        <div class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2 text-yellow-500">Veilig</h3>
            <p class="text-gray-600">Jouw gegevens en ervaring zijn bij ons goed beschermd.</p>
        </div>
    </div>
</section>

<!-- Over ons -->
<section class="py-20 bg-gray-100">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6 text-yellow-500">Over ons</h2>
        <p class="text-gray-700 text-lg">
            Brooklyn Bowlingcenter is al meer dan 15 jaar dé plek voor sportief plezier en ontspanning. 
            Of je nu met vrienden, familie of collega’s komt – bij ons beleef je een onvergetelijke avond.
        </p>
    </div>
</section>

<!-- Openingstijden -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6 text-center text-yellow-500">Openingstijden</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
            <div>
                <h3 class="font-semibold text-gray-800">Maandag - Donderdag</h3>
                <p>12:00 – 22:00</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Vrijdag</h3>
                <p>12:00 – 00:00</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Zaterdag</h3>
                <p>10:00 – 00:00</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Zondag</h3>
                <p>10:00 – 22:00</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Feestdagen</h3>
                <p>Gesloten</p>
            </div>
        </div>
    </div>
</section>

<!-- Prijslijst -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6 text-center text-yellow-500">Prijslijst</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-yellow-200 text-gray-900">
                    <th class="px-4 py-2">Dienst</th>
                    <th class="px-4 py-2">Prijs</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="px-4 py-2">Bowlen per uur (per baan)</td>
                    <td class="px-4 py-2">€25,00</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2">Kinderfeestje (incl. snacks & drinken)</td>
                    <td class="px-4 py-2">€12,50 p.p.</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2">Bedrijfsarrangement</td>
                    <td class="px-4 py-2">Op aanvraag</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2">Schoenenhuur</td>
                    <td class="px-4 py-2">€2,50 p.p.</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<!-- Contact -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6 text-yellow-500">Contact</h2>
        <p class="mb-4">Heb je vragen of wil je een arrangement op maat? Neem gerust contact met ons op.</p>
        <p class="text-gray-700">
            📍 Adres: Bowlinglaan 123, 1011AB Brooklyn<br>
            📞 Telefoon: 020-1234567<br>
            ✉️ E-mail: info@brooklynbowling.nl
        </p>
    </div>
</section>

<!-- Footer -->
<footer class="bg-yellow-400 py-6 mt-20">
    <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
        &copy; 2025 Brooklyn Bowlingcenter. Alle rechten voorbehouden.
    </div>
</footer>

</body>
</html>
