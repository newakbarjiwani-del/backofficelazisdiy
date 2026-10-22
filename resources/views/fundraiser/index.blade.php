<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Fundraiser</title>
</head>

<body class="h-screen bg-gray-100 overflow-x-hidden">
    @include('sweetalert::alert')
    <div class="flex h-full">
        <aside class="w-56 h-full bg-white shadow-md fixed z-40">
            @include('includes.sidebar')
        </aside>

        <div class="flex-1 ml-56">
            <header class="bg-white p-4 shadow-md mb-10">
                @include('includes.header')
            </header>

            <main class="p-4 max-w-6xl mx-auto">
                <div class="bg-white rounded-md shadow-xl mx-2">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h1 class="text-2xl font-semibold text-gray-900">Tracking Fundraiser</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Pantau jumlah orang yang diundang dan total donasi sukses per fundraiser.
                        </p>
                    </div>

                    <div class="overflow-auto">
                        <div class="max-h-[calc(100vh-240px)] overflow-y-auto">
                            <table class="min-w-full bg-white">
                                <thead class="sticky top-0 z-10 bg-gray-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">HP</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orang</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Donasi</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Per Campaign</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($fundraisers as $index => $item)
                                        <tr>
                                            <td class="px-5 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                            <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $item['name'] ?: '-' }}</td>
                                            <td class="px-5 py-4 text-sm font-semibold tracking-wider text-orange-600">
                                                {{ $item['code'] }}
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-600">{{ $item['phone_number'] ?: '-' }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-700">{{ $item['donor_count'] ?? 0 }}</td>
                                            <td class="px-5 py-4 text-sm font-semibold text-gray-900">
                                                Rp {{ number_format((float) ($item['total_amount'] ?? 0), 0, ',', '.') }}
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-600">
                                                @php $campaigns = $item['campaigns'] ?? []; @endphp
                                                @if (count($campaigns) === 0)
                                                    <span class="text-xs text-gray-400">Belum ada donasi</span>
                                                @else
                                                    <div class="space-y-1 max-w-xs">
                                                        @foreach ($campaigns as $campaign)
                                                            <div class="rounded bg-gray-50 px-2 py-1 text-xs">
                                                                <p class="font-medium text-gray-800 truncate">
                                                                    {{ $campaign['campaign_name'] ?: ('Campaign #' . $campaign['campaign_id']) }}
                                                                </p>
                                                                <p class="text-gray-500">
                                                                    {{ $campaign['donor_count'] ?? 0 }} orang ·
                                                                    Rp {{ number_format((float) ($campaign['total_amount'] ?? 0), 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-5 py-10 text-center text-sm text-gray-500">
                                                Belum ada fundraiser terdaftar, atau API belum bisa diakses.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
