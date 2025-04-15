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
            <h1 class="text-2xl font-bold text-gray-900">Brooklyn Bowlingcenter</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Scores</h2>
            <a href="{{ route('score.create') }}" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-md shadow">Add New Score</a>
        </div>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">First Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Last Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Score</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Membership Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scores as $score)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $score->firstName }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $score->lastName }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $score->amount }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $score->membershipType }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('score.edit', $score->id) }}" class="bg-yellow-400 text-gray-900 px-2 py-1 rounded-md shadow">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <footer class="bg-yellow-400 py-6 mt-20">
        <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
            &copy; 2025 MyWebsite. All rights reserved.
        </div>
    </footer>

</body>
</html>
