@props(['title'])

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ empty($title) ? '' : "{$title} - " }}Did You Do That Yet? </title>
    @vite(['resources/js/app.js'])
</head>

<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ url('/') }}">
                                ☑️
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="relative ml-3">
                                @auth
                                    <form method="POST" action="/logout">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-white font-bold rounded hover:bg-black/50 p-2">
                                            Log out
                                        </button>
                                    </form>
                                @endauth

                                @guest
                                    <a href="{{ url('/login') }}" class="text-white font-bold">
                                        Login
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    {{ $title ?? 'Did you do that yet?' }}
                </h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-2 text-red">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
