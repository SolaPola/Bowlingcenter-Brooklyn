<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Score</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

    <header class="bg-yellow-400 shadow">
        <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Edit Score</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <form action="{{ route('score.update', $id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="firstName" class="block text-sm font-medium">First Name</label>
                <input type="text" id="firstName" name="firstName" value="{{ old('firstName', $score->firstName) }}" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="lastName" class="block text-sm font-medium">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="{{ old('lastName', $score->lastName) }}" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium">Score</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount', $score->amount) }}" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="membershipType" class="block text-sm font-medium">Membership Type</label>
                <input type="text" id="membershipType" name="membershipType" value="{{ old('membershipType', $score->membershipType) }}" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-md shadow">Update</button>
            </div>
        </form>
    </main>

</body>
</html>
