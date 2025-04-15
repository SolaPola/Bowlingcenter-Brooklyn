<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Score</title>
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
        <h2 class="text-xl font-bold mb-4">Add New Score</h2>
        <form action="{{ route('score.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="firstName" id="firstName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Score</label>
                <input type="number" name="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="membershipType" class="block text-sm font-medium text-gray-700">Membership Type</label>
                <select name="membershipType" id="membershipType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="Basis">Basis</option>
                    <option value="Premium">Premium</option>
                    <option value="VIP">VIP</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-md shadow">Submit</button>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-yellow-400 py-6 mt-20">
        <div class="max-w-7xl mx-auto text-center text-gray-900 font-medium">
            &copy; 2025 MyWebsite. All rights reserved.
        </div>
    </footer>

</body>
</html>
