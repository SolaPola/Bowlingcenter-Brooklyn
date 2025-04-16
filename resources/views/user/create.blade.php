{{-- layout --}}
<x-app-layout>

    {{-- title on the top of the screen --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Account toevoegen
        </h2>
    </x-slot>

    @if (session('error'))

    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-3/4 m-auto text-center my-6" role="alert">
        <h3 class="block sm:inline">{{ session('error') }}</h3>
       
    </div>
    @endif
    <div class="overflow-x-auto">
        <form action="{{ route('users.store') }} " method="post"
            class="w-3/4 bg-white dark:bg-gray-800 m-auto mt-5 mb-5 p-5 rounded shadow-md">
            @csrf
            <div class="w-full bg-black h-1 my-3"></div>
            <label for="Username">Gebruikersnaam</label>
            <input type="text" name="Username" id="Username" placeholder="JohnDoe14" value="{{ old('Username') }}"
                class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 mb-2" >
            @error('Username')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" placeholder="Email@mail.com"  value="{{ old('Email') }}"
                class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 mb-2" >
            @error('Email')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
            <label for="Password">Wachtwoord</label>
            <input type="password" name="Password" id="Password" placeholder="123456789" value="{{ old('Password') }}"
                class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 mb-2" >
            @error('Password')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
            <label for="PasswordRepeat">Herhaal wachtwoord</label>
            <input type="password" name="PasswordRepeat" id="PasswordRepeat" placeholder="123456789" value="{{ old('PasswordRepeat') }}"
                class="w-full p-2 rounded border border-gray-300 dark:border-gray-700" >
            @error('PasswordRepeat')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
            <div class="w-full bg-black h-1 my-3"></div>
            <select name="Role" id="Role" class="w-full p-2 rounded border border-gray-300 dark:border-gray-700 mb-2"
                required>
                <option value="nothing" selected>Selecteer een rol</option>
                <option value="Gebruiker">Gebruiker</option>
                <option value="Administrator">Administrator</option>
            </select>
            @error('Role')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="bg-green-700 text-white p-2 rounded hover:bg-green-800 dark:hover:bg-green-900">Opslaan</button>
        </form>

        <div class="w-full justify-center flex my-6">
            {{-- button to create a new user --}}
            <a href="{{ route('users.index') }}"
                class="bg-blue-700 text-white p-2 rounded hover:bg-blue-800 dark:hover:bg-blue-900">Terug naar
                overzicht</a>

        </div>
    </div>



</x-app-layout>