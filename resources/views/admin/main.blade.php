<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/lazismu-logo.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    <title>Dashboard</title>
</head>

<body class="h-screen bg-gray-100">
    @include('sweetalert::alert')

    <div class="flex h-full">
        <aside class="w-56 h-full bg-white shadow-md fixed">
            @include('includes.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 pl-56">
            <!-- Header -->
            <header class="bg-white p-4 shadow-md mb-10">
                @include('includes.header')
            </header>

            <!-- Content -->
            <main class="p-4 mt-10"> <!-- Padding top for the main content -->
                <div class="flex justify-between items-center w-full">
                    <h1 class="font-bold text-2xl">Dashboard</h1>
                    <div class="flex flex-col items-center">
                        <form action="{{ route('dashboard.index') }}" method="get">
                            <div class="flex grid-cols-3 space-x-3 justify-center items-center">
                                <label for="start_date">Tanggal mulai:</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="shadow-md text-sm rounded-md px-2 py-1" value="{{ request('start_date') }}">
                                <p class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                    </svg>

                                </p>
                                <label for="end_date">Tanggal selesai:</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="shadow-md text-sm rounded-md px-2 py-1" value="{{ request('end_date') }}">
                                <button type="submit"
                                    class="text-white bg-green-600 rounded-md shadow-md px-3 py-1">Filter</button>
                                <button type="button" onclick="resetFilter()"
                                    class="text-white bg-red-600 rounded-md shadow-md px-3 py-1">Reset</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="grid gap-4 grid-cols-4">

                    <div
                        class="bg-gradient-to-br from-neutral-50 to-gray-100 border-1 border-gray-400 rounded-md flex flex-col shadow-md p-4 mt-5 justify-center items-center">
                        <div class="pb-2">
                            <h2 class="font-semibold">Total Donasi</h2>
                            <p class="text-lg font-bold">
                                Rp {{ number_format($totalTransaction ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 border-t-2 border-gray-400 w-full">
                            <div class="border-r-2 w-full border-gray-400 p-2">
                                <h3 class="font-semibold text-sm text-blue-600 mb-2">Migrasi</h3>
                                <p class="text-xs font-bold">
                                    Rp {{ number_format($totalMigration ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="p-2 w-full">
                                <h3 class="font-semibold text-sm text-green-600 mb-2">QRIS ICT</h3>
                                <p class="text-xs font-bold">
                                    Rp {{ number_format($totalQris ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                    </div>
                    <div
                        class="bg-gradient-to-br from-neutral-50 to-gray-100 border-1 border-gray-400 rounded-md shadow-md p-4 mt-5 text-center">
                        <div class="pb-2">
                            <h2 class="font-semibold mb-10">Jumlah Donatur</h2>
                            <p class="mt-2 font-bold text-lg">
                                {{ number_format($totalDonatur ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-neutral-50 to-gray-100 border-1 border-gray-400 rounded-md flex flex-col shadow-md p-4 mt-5 justify-center items-center">
                        <div class="pb-2">
                            <h2 class="font-semibold">Jumlah Donasi</h2>
                            <p class="text-center font-bold text-lg">
                                {{ number_format($countTransaction ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="grid grid-cols-2 border-t-2 border-gray-400 w-full">
                            <div class="border-r-2 border-gray-400 p-2">
                                <h3 class="font-semibold text-sm text-green-600">Success</h3>
                                <p class="text-sm font-bold">{{ number_format($countTransaction ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="p-2">
                                <h3 class="font-semibold text-sm text-yellow-600">Waiting</h3>
                                <p class="text-sm font-bold">{{ number_format($countBilling ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>

                    </div>

                    <div
                        class="bg-gradient-to-br from-neutral-50 to-gray-100 border-1 border-gray-400 rounded-md shadow-md p-4 mt-5 text-center">
                        <div class="pb-2">
                            <h2 class="font-semibold mb-10">Total tagihan ICT</h2>
                            <p class="mt-2 text-lg font-bold">
                                Rp {{ number_format($totalForIct ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                </div>

                <div class="mt-10 flex gap-4">
                    <div class="w-1/2 h-1/2">
                        <canvas id="transactionChart" class="w-full h-auto"></canvas>
                    </div>
                    <div class="w-1/2 h-1/2">
                        <canvas id="campaignschart" class="w-full h-auto"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/resetfilter.js') }}"></script>
    <script src="{{ asset('js/transactionChart.js') }}"></script>
    <script src="{{ asset('js/campaignchart.js') }}"></script>




</body>

</html>
