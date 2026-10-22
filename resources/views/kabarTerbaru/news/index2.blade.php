<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- @vite('resources/css/app.css') --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">


    <title>Kabar Terbaru</title>
    <style>
        [x-cloak] {
            display: none !important;
        }

        ,

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="h-screen bg-gray-100 overflow-x-hidden">
    @include('sweetalert::alert')
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="w-56 h-full bg-white shadow-md fixed z-40">
            @include('includes.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-56">
            <!-- Header -->
            <header class="bg-white p-4 shadow-md mb-10">
                @include('includes.header')
            </header>

            <!-- Content -->
            <main class="p-4 max-w-5xl mx-auto">
                <div class="bg-white col-span-3 rounded-md mt-1 mx-2 shadow-xl">
                    <div class="mx-5">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex-col">
                                <h1 class="text-2xl font-semibold text-gray-900 mt-2 py-2">Campaign</h1>
                                <div class="mt-2">
                                    <div class="relative mt-5 flex">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search" id="searchInput"
                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            placeholder="cari nama campaign..." value="{{ request('search') }}">
                                        <div class="ml-5 flex items-center justify-center rounded-md shadow-md">
                                            <select name="category_id" id="categoryDropdown"
                                                class="form-control mx-2 my-1 bg-white border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">Semua kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category['id'] }}"
                                                        {{ request('category_id') == $category['id'] ? 'selected' : '' }}>
                                                        {{ $category['campaign_category'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>





                        </div>
                        <div class="overflow-auto w-full">
                            <div class="max-h-[calc(100vh-270px)] overflow-y-auto">
                                <table id="transaction-table" class="min-w-full bg-white table-auto overflow-x-auto">
                                    <thead class="sticky top-0 z-10">
                                        <!-- Table Header -->
                                        <tr>

                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kategori
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Lokasi
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Target
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Terkumpul </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aktif </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($campaigns as $index => $campaign)
                                            @php
                                                $globalIndex =
                                                    ($pagination['current_page'] - 1) * $pagination['per_page'] +
                                                    $index +
                                                    1;
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <div x-data="{ isOpen: false }">
                                                            <button 
                                                                class="bg-green-600 rounded-md shadow-md px-1 py-1 text-white" 
                                                                type="button"
                                                                value="{{ $campaign['id'] }}" 
                                                                @click="isOpen = true">
                                                                Buat kabar terbaru
                                                            </button>
                                                            <div>
                                                                @include('kabarTerbaru.news.create')
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                                    {{ $campaign['category_name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $campaign['campaign_name'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $campaign['location'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($campaign['target_amount'], 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($campaign['current_amount'], 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($campaign['active'] == 1)
                                                        <span
                                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                            Aktif
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                                            Tidak Aktif
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                                    <div class="flex flex-col items-center justify-center space-y-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-8 w-8 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <p class="text-gray-500">
                                                            @if (request('search') && request('category_id'))
                                                                Tidak ada data ditemukan untuk pencarian
                                                                <strong>"{{ request('search') }}"</strong> pada
                                                                kategori
                                                                <strong>"{{ $categories->where('id', request('category_id'))->first()['campaign_category'] ?? 'Kategori Tidak Ditemukan' }}"</strong>.
                                                            @elseif (request('search'))
                                                                Tidak ada data ditemukan untuk pencarian
                                                                <strong>"{{ request('search') }}"</strong>.
                                                            @elseif (request('category_id'))
                                                                Tidak ada data ditemukan untuk kategori
                                                                <strong>"{{ $categories->where('id', request('category_id'))->first()['campaign_category'] ?? 'Kategori Tidak Ditemukan' }}"</strong>.
                                                            @else
                                                                Data yang anda cari atau filter tidak ditemukan.
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div id="pagination"
                            class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        Showing
                                        <span
                                            class="font-medium">{{ ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 }}</span>
                                        to
                                        <span class="font-medium">
                                            {{ $pagination['current_page'] * $pagination['per_page'] > $pagination['total'] ? $pagination['total'] : $pagination['current_page'] * $pagination['per_page'] }}
                                        </span>
                                        of
                                        <span class="font-medium">{{ $pagination['total'] }}</span>
                                        results
                                    </p>
                                </div>
                                <div>
                                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                                        aria-label="Pagination">
                                        <!-- Previous Button -->
                                        @if ($pagination['current_page'] > 1)
                                            <a href="?page={{ $pagination['current_page'] - 1 }}"
                                                class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <span>Previous</span>
                                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif

                                        <!-- Page Numbers -->
                                        @php
                                            $start = 1;
                                            $end = $pagination['last_page'];

                                            if ($pagination['last_page'] > 7) {
                                                if ($pagination['current_page'] <= 4) {
                                                    $start = 1;
                                                    $end = 5;
                                                } elseif ($pagination['current_page'] >= $pagination['last_page'] - 3) {
                                                    $start = $pagination['last_page'] - 4;
                                                    $end = $pagination['last_page'];
                                                } else {
                                                    $start = $pagination['current_page'] - 2;
                                                    $end = $pagination['current_page'] + 2;
                                                }
                                            }
                                        @endphp

                                        @if ($start > 1)
                                            <a href="?page=1"
                                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">1</a>
                                            @if ($start > 2)
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">...</span>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            <a href="?page={{ $i }}"
                                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 {{ $i == $pagination['current_page'] ? 'bg-indigo-600 text-white' : '' }}">
                                                {{ $i }}
                                            </a>
                                        @endfor

                                        @if ($end < $pagination['last_page'])
                                            @if ($end < $pagination['last_page'] - 1)
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">...</span>
                                            @endif
                                            <a href="?page={{ $pagination['last_page'] }}"
                                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">{{ $pagination['last_page'] }}</a>
                                        @endif

                                        <!-- Next Button -->
                                        @if ($pagination['current_page'] < $pagination['last_page'])
                                            <a href="?page={{ $pagination['current_page'] + 1 }}"
                                                class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <span>Next</span>
                                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        </main>
    </div>
    </div>

    <script>
        // let typingTimer;
        // const doneTypingInterval = 500; // Wait for 500ms after user stops typing
        // const searchInput = document.getElementById('searchInput');
        // const transactionTable = document.getElementById('transaction-table');

        // // Add event listener for search input
        // searchInput.addEventListener('keyup', function() {
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(performSearch, doneTypingInterval);
        // });

        // // Initialize search input from URL params
        // document.addEventListener('DOMContentLoaded', function() {
        //     const urlParams = new URLSearchParams(window.location.search);
        //     const searchQuery = urlParams.get('search');
        //     if (searchQuery) {
        //         searchInput.value = searchQuery;
        //         performSearch();
        //     }
        // });

        // function performSearch() {
        //     const searchQuery = searchInput.value;

        //     // Update URL with search parameter
        //     const url = new URL(window.location);
        //     if (searchQuery) {
        //         url.searchParams.set('search', searchQuery);
        //         url.searchParams.set('page', '1'); // Reset to first page on new search
        //     } else {
        //         url.searchParams.delete('search');
        //     }
        //     window.history.pushState({}, '', url);

        //     // Show loading state
        //     const tbody = transactionTable.querySelector('tbody');
        //     tbody.innerHTML = `
    // <tr>
    //     <td colspan="8" class="px-6 py-4 text-center">
    //         <div class="flex justify-center items-center">
    //             <svg class="animate-spin h-5 w-5 mr-3 text-gray-500" viewBox="0 0 24 24">
    //                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
    //                 <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    //             </svg>
    //             Searching...
    //         </div>
    //     </td>
    // </tr>
    // `;

        //     // Make AJAX request
        //     fetch(`/campaigns/search?search=${encodeURIComponent(searchQuery)}`, {
        //             headers: {
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             updateTable(data.campaigns, data.pagination);
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             tbody.innerHTML = `
    //     <tr>
    //         <td colspan="8" class="px-6 py-4 text-center text-red-500">
    //             An error occurred while searching. Please try again.
    //         </td>
    //     </tr>
    // `;
        //         });
        // }

        // function updateTable(campaigns, pagination) {
        //     // Existing table update code remains the same
        //     const tbody = transactionTable.querySelector('tbody');

        //     if (campaigns.length === 0) {
        //         tbody.innerHTML = `
    //     <tr>
    //         <td colspan="8" class="px-6 py-4 text-center">
    //             <div class="flex flex-col items-center justify-center space-y-2">
    //                 <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    //                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    //                 </svg>
    //                 <p class="text-gray-500">Data nama campaign yang anda cari tidak ditemukan!.</p>
    //             </div>
    //         </td>
    //     </tr>
    // `;
        //         return;
        //     }

        //     tbody.innerHTML = campaigns.map((campaign, index) => `
    // <tr>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
    //         ${(pagination.current_page - 1) * pagination.per_page + index + 1}
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         ${campaign.category_name}
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         ${campaign.campaign_name ?? 'Email not available'}
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         ${campaign.location}
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         Rp ${new Intl.NumberFormat('id-ID').format(campaign.target_amount)}
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         Rp ${new Intl.NumberFormat('id-ID').format(campaign.current_amount)}
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         ${campaign.active == 1 
    //             ? '<span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Aktif</span>'
    //             : '<span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Tidak Aktif</span>'
    //         }
    //     </td>
    //     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    //         <div class="flex items-center gap-2">
    //             <button class="text-yellow-800">
    //                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5">
    //                     <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
    //                 </svg>
    //             </button>
    //             <button class="text-red-600">
    //                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5">
    //                     <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
    //                 </svg>
    //             </button>
    //         </div>
    //     </td>
    // </tr>
    // `).join('');

        //     updatePagination(pagination);
        // }

        // function updatePagination(pagination) {
        //     const paginationContainer = document.querySelector('#pagination nav');
        //     let paginationHTML = '';

        //     // Previous button
        //     if (pagination.current_page > 1) {
        //         paginationHTML += `
    //     <a href="javascript:void(0)" 
    //        onclick="handlePageClick(${pagination.current_page - 1})"
    //        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
    //         <span>Previous</span>
    //         <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
    //             <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
    //         </svg>
    //     </a>
    // `;
        //     }

        //     // Calculate page range
        //     let start = 1;
        //     let end = pagination.last_page;
        //     const showPages = 7; // Total number of page buttons to show

        //     if (pagination.last_page > showPages) {
        //         // Always show first page
        //         paginationHTML += `
    //     <a href="javascript:void(0)" 
    //        onclick="handlePageClick(1)"
    //        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 ${1 === pagination.current_page ? 'bg-indigo-600 text-white' : ''}">
    //         1
    //     </a>
    // `;

        //         // Calculate start and end pages
        //         if (pagination.current_page <= 4) {
        //             // Near the start
        //             start = 2;
        //             end = 5;

        //         } else if (pagination.current_page >= pagination.last_page - 3) {
        //             // Near the end
        //             start = pagination.last_page - 4;
        //             end = pagination.last_page - 1;

        //         } else {
        //             // In the middle
        //             start = pagination.current_page - 1;
        //             end = pagination.current_page + 1;
        //         }

        //         // Add first ellipsis
        //         if (start > 2) {
        //             paginationHTML += `
    //         <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">...</span>
    //     `;
        //         }

        //         // Add middle pages
        //         for (let i = start; i <= end; i++) {
        //             paginationHTML += `
    //         <a href="javascript:void(0)" 
    //            onclick="handlePageClick(${i})"
    //            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 ${i === pagination.current_page ? 'bg-indigo-600 text-white' : ''}">
    //             ${i}
    //         </a>
    //     `;
        //         }

        //         // Add last ellipsis
        //         if (end < pagination.last_page - 1) {
        //             paginationHTML += `
    //         <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">...</span>
    //     `;
        //         }

        //         // Always show last page
        //         paginationHTML += `
    //     <a href="javascript:void(0)" 
    //        onclick="handlePageClick(${pagination.last_page})"
    //        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 ${pagination.last_page === pagination.current_page ? 'bg-indigo-600 text-white' : ''}">
    //         ${pagination.last_page}
    //     </a>
    // `;
        //     } else {
        //         // If total pages are less than or equal to showPages, show all pages
        //         for (let i = 1; i <= pagination.last_page; i++) {
        //             paginationHTML += `
    //         <a href="javascript:void(0)" 
    //            onclick="handlePageClick(${i})"
    //            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 ${i === pagination.current_page ? 'bg-indigo-600 text-white' : ''}">
    //             ${i}
    //         </a>
    //     `;
        //         }
        //     }

        //     // Next button
        //     if (pagination.current_page < pagination.last_page) {
        //         paginationHTML += `
    //     <a href="javascript:void(0)" 
    //        onclick="handlePageClick(${pagination.current_page + 1})"
    //        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
    //         <span>Next</span>
    //         <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
    //             <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
    //         </svg>
    //     </a>
    // `;
        //     }

        //     paginationContainer.innerHTML = paginationHTML;
        // }

        // // Handle pagination clicks
        // function handlePageClick(page) {
        //     const url = new URL(window.location);
        //     url.searchParams.set('page', page);
        //     window.history.pushState({}, '', url);

        //     const searchQuery = url.searchParams.get('search') || '';

        //     fetch(`/campaigns/search?search=${encodeURIComponent(searchQuery)}&page=${page}`, {
        //             headers: {
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             updateTable(data.campaigns, data.pagination);
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // }

        // Ambil elemen input
        const formattedInput = document.getElementById('formatted_target_amount');
        const rawInput = document.getElementById('target_amount');

        // Event untuk memformat tampilan
        formattedInput.addEventListener('input', (e) => {
            // Ambil nilai tanpa karakter selain angka
            const rawValue = e.target.value.replace(/[^0-9]/g, '');
            // Format tampilan dengan titik pemisah ribuan
            e.target.value = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            // Simpan nilai asli ke input tersembunyi
            rawInput.value = rawValue;
        });

        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("campaign-form");
            const fileInputs = ["campaign_thumbnail", "campaign_image1", "campaign_image2", "campaign_image3"];

            // Add change event listeners to all file inputs
            fileInputs.forEach((fileInputId) => {
                const fileInput = document.getElementById(fileInputId);
                if (fileInput) {
                    // Create preview container for each input
                    const previewContainer = document.createElement("div");
                    previewContainer.id = `${fileInputId}-preview-container`;
                    previewContainer.className = "mt-2 hidden"; // Initially hidden

                    // Create preview image element
                    const previewImg = document.createElement("img");
                    previewImg.id = `${fileInputId}-preview`;
                    previewImg.className = "max-h-32 rounded-lg shadow-sm";
                    previewContainer.appendChild(previewImg);

                    // Insert preview container after the error message
                    const errorElement = document.getElementById(`${fileInputId}-error`);
                    errorElement.parentNode.insertBefore(previewContainer, errorElement.nextSibling);

                    fileInput.addEventListener("change", function() {
                        validateAndPreviewFile(fileInputId);
                    });
                }
            });

            // Validate file size and show preview
            function validateAndPreviewFile(fileInputId) {
                const fileInput = document.getElementById(fileInputId);
                const errorElement = document.getElementById(`${fileInputId}-error`);
                const previewContainer = document.getElementById(`${fileInputId}-preview-container`);
                const previewImg = document.getElementById(`${fileInputId}-preview`);

                // Hide preview initially
                previewContainer.classList.add("hidden");

                if (fileInput && fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileSize = file.size / 1024 / 1024; // Convert to MB

                    if (fileSize > 2) {
                        // File too large
                        errorElement.classList.remove("hidden");
                        fileInput.value = ''; // Clear the input
                        return false;
                    } else {
                        // Valid file, show preview
                        errorElement.classList.add("hidden");

                        // Create object URL for preview
                        const objectUrl = URL.createObjectURL(file);
                        previewImg.src = objectUrl;
                        previewContainer.classList.remove("hidden");

                        // Clean up object URL when image loads
                        previewImg.onload = () => {
                            URL.revokeObjectURL(objectUrl);
                        };

                        return true;
                    }
                }
                return true;
            }

            // Form submit handler
            form.addEventListener("submit", function(event) {
                let isValid = true;

                // Validate all file inputs
                fileInputs.forEach((fileInputId) => {
                    const fileInput = document.getElementById(fileInputId);

                    // Only validate required files or files that have been selected
                    if (fileInput && (fileInput.hasAttribute('required') || fileInput.files.length >
                            0)) {
                        if (!validateAndPreviewFile(fileInputId)) {
                            isValid = false;
                        }
                    }
                });

                // Prevent form submission if validation fails
                if (!isValid) {
                    event.preventDefault();
                    alert("Form tidak dapat dikirim. Pastikan semua file berukuran kurang dari 2MB.");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    {{-- script dropdown category filtter --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const categoryDropdown = document.getElementById('categoryDropdown');

            // Fungsi untuk mengupdate URL berdasarkan input
            const updateUrl = () => {
                const baseUrl = window.location.origin + window.location.pathname;
                const search = searchInput.value.trim();
                const categoryId = categoryDropdown.value;

                // Buat query string
                const params = new URLSearchParams();
                if (search) params.append('search', search);
                if (categoryId) params.append('category_id', categoryId);

                // Redirect ke URL baru
                window.location.href = `${baseUrl}?${params.toString()}`;
            };

            /// Event listener untuk input pencarian
            searchInput.addEventListener('input', () => {
                // Tambahkan delay agar tidak reload setiap karakter
                setTimeout(updateUrl, 300);
            });

            // Event listener untuk dropdown kategori
            categoryDropdown.addEventListener('change', updateUrl);
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //     // Menambahkan event listener untuk checkbox
        //     document.getElementById('priority').addEventListener('change', function() {
        //         // Jika dicentang, ubah nilai input hidden "priority" menjadi 1
        //         if (this.checked) {
        //             document.querySelector('input[name="priority"]').value = 1;
        //         } else {
        //             // Jika tidak dicentang, ubah nilai input hidden "priority" menjadi 0
        //             document.querySelector('input[name="priority"]').value = 0;
        //         }


        //     });
        // });
    </script>

</body>

</html>
