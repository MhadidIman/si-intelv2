<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        <aside class="w-64 bg-slate-900 border-r border-slate-800 flex-shrink-0 h-screen sticky top-0 overflow-y-auto">
            <livewire:layout.navigation />
        </aside>

        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">

            <div class="md:hidden bg-white border-b border-gray-200 p-4 flex justify-between items-center">
                <div class="font-bold text-lg text-gray-800">SI-INTEL</div>
            </div>

            @if (isset($header))
            <header class="bg-white shadow z-10">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>