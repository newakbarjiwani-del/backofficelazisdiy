<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    <title>Transaksi</title>
</head>

<body class="h-screen bg-gray-100 overflow-x-hidden">
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
                <div class="bg-white rounded-md shadow-xl">
                    <div class="mx-5">
                        <div class="flex justify-between items-center mb-3">
                            <div class="mt-2">
                                <h1 class="text-2xl font-semibold text-gray-900">Transaksi</h1>
                                <div class="mt-2">
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Filter
                                        kategori</label>
                                    <select name="category" id="category"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        {{-- <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}></option> --}}
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}"
                                                {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <!-- Form Pencarian -->
                            <div class="relative mt-2 w-72">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="searchInput"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="cari id invoice atau nama campaign...">
                            </div>
                        </div>
                        <div class="overflow-auto w-full">
                            <div class="max-h-[calc(100vh-270px)] overflow-y-auto">
                                <table id="transaction-table" class="min-w-full bg-white table-auto">
                                    <thead class="sticky top-0 z-10">
                                        <!-- Table Header -->
                                        <tr>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ID Invoice
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kategori
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b text-center border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama campaign/ZIS
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Donatur
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No HP
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pesan
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Metode </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Donasi 
                                            </th>
                                            <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal transaksi </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Biaya admin 
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Asal transaksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">

                                        @foreach ($transactions as $trans)
                                            <!-- Table Rows -->
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ ($pagination['current_page'] - 1) * $pagination['per_page'] + $loop->iteration }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['invoice_id'] ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['category'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if (isset($trans['campaign_name']))
                                                        {{ $trans['campaign_name'] }}
                                                    @elseif(isset($trans['zakat_name']))
                                                        {{ $trans['zakat_name'] }}
                                                    @elseif(isset($trans['infak_name']))
                                                        {{ $trans['infak_name'] }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['donatur'] ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['phone_number'] ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['message'] ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['method'] ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ ($trans['transaction_amount']) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['transaction_date'] ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                   Rp {{ $trans['for_ict'] !== null ? number_format($trans['for_ict'], 0, ',', '.') : '0' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $trans['asal_transaksi'] ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div id="pagination"
                                class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">


                                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
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
                                            <!-- Tombol Previous -->
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

                                            <!-- Tombol Nomor Halaman -->
                                            @for ($i = 1; $i <= $pagination['last_page']; $i++)
                                                <a href="?page={{ $i }}"
                                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 {{ $i == $pagination['current_page'] ? 'bg-indigo-600 text-white' : '' }}">
                                                    {{ $i }}
                                                </a>
                                            @endfor

                                            <!-- Tombol Next -->
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
                            </div> --}}
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

                                        <!-- Page Numbers with Ellipsis -->
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
                                                    $start = $pagination['current_page'] - 1;
                                                    $end = $pagination['current_page'] + 1;
                                                }
                                            }
                                        @endphp

                                        <!-- First Page -->
                                        @if ($pagination['last_page'] > 7)
                                            <a href="?page=1"
                                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 {{ 1 == $pagination['current_page'] ? 'bg-indigo-600 text-white' : '' }}">
                                                1
                                            </a>

                                            <!-- First Ellipsis -->
                                            @if ($start > 2)
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">...</span>
                                            @endif
                                        @endif

                                        <!-- Middle Pages -->
                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i > 1 && $i < $pagination['last_page'])
                                                <a href="?page={{ $i }}"
                                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 {{ $i == $pagination['current_page'] ? 'bg-indigo-600 text-white' : '' }}">
                                                    {{ $i }}
                                                </a>
                                            @endif
                                        @endfor

                                        <!-- Last Section -->
                                        @if ($pagination['last_page'] > 7)
                                            <!-- Last Ellipsis -->
                                            @if ($end < $pagination['last_page'] - 1)
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">...</span>
                                            @endif

                                            <!-- Last Page -->
                                            <a href="?page={{ $pagination['last_page'] }}"
                                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 {{ $pagination['last_page'] == $pagination['current_page'] ? 'bg-indigo-600 text-white' : '' }}">
                                                {{ $pagination['last_page'] }}
                                            </a>
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
            </main>
        </div>
    </div>
    {{-- sudah benar script pertama hanya kurang penanganan jika data tidak ditemukan --}}
    {{-- <script>
        // Add this script after your table HTML
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categorySelect = document.getElementById('category');
            const transactionTable = document.getElementById('transaction-table');
            const pagination = document.getElementById('pagination');

            // Function to update the table content
            const updateTable = (data) => {
                const tbody = transactionTable.querySelector('tbody');
                tbody.innerHTML = '';

                data.transactions.forEach((trans, index) => {
                    const row = `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${index + 1}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.invoice_id}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.category}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.campaign_name}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.donatur}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.phone_number}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.message}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.method}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Rp ${new Intl.NumberFormat('id-ID').format(trans.transaction_amount)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.transaction_date}
                    </td>
                </tr>
            `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });

                // Update pagination
                updatePagination(data.pagination);

                // Update URL with current filters
                updateURL();
            };

            // Function to update pagination
            const updatePagination = (paginationData) => {
                const paginationHtml = `
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">${(paginationData.current_page - 1) * paginationData.per_page + 1}</span>
                        to
                        <span class="font-medium">
                            ${Math.min(paginationData.current_page * paginationData.per_page, paginationData.total)}
                        </span>
                        of
                        <span class="font-medium">${paginationData.total}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        ${generatePaginationButtons(paginationData)}
                    </nav>
                </div>
            </div>
        `;
                pagination.innerHTML = paginationHtml;

                // Reattach click handlers to pagination buttons
                attachPaginationHandlers();
            };

            // Function to generate pagination buttons
            const generatePaginationButtons = (paginationData) => {
                let buttons = '';

                // Previous button
                if (paginationData.current_page > 1) {
                    buttons += `
                <a href="#" data-page="${paginationData.current_page - 1}" 
                   class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span>Previous</span>
                </a>
            `;
                }

                // Page numbers
                for (let i = 1; i <= paginationData.last_page; i++) {
                    buttons += `
                <a href="#" data-page="${i}"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium ${i === paginationData.current_page 
                       ? 'bg-indigo-600 text-white' 
                       : 'text-gray-900'} ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    ${i}
                </a>
            `;
                }

                // Next button
                if (paginationData.current_page < paginationData.last_page) {
                    buttons += `
                <a href="#" data-page="${paginationData.current_page + 1}"
                   class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span>Next</span>
                </a>
            `;
                }

                return buttons;
            };

            // Function to attach pagination click handlers
            const attachPaginationHandlers = () => {
                const paginationLinks = pagination.querySelectorAll('a[data-page]');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const page = e.currentTarget.dataset.page;
                        fetchData(page);
                    });
                });
            };

            // Function to update URL with current filters
            const updateURL = () => {
                const searchParams = new URLSearchParams(window.location.search);
                const currentSearch = searchInput.value;
                const currentCategory = categorySelect.value;

                if (currentSearch) {
                    searchParams.set('search', currentSearch);
                } else {
                    searchParams.delete('search');
                }

                if (currentCategory !== 'all') {
                    searchParams.set('category', currentCategory);
                } else {
                    searchParams.delete('category');
                }

                const newUrl =
                    `${window.location.pathname}${searchParams.toString() ? '?' + searchParams.toString() : ''}`;
                window.history.pushState({}, '', newUrl);
            };

            // Function to fetch data with combined filters
            const fetchData = async (page = 1) => {
                const searchQuery = searchInput.value;
                const selectedCategory = categorySelect.value;

                const params = new URLSearchParams({
                    page: page,
                    ajax: 1
                });

                if (searchQuery) {
                    params.append('search', searchQuery);
                }

                if (selectedCategory !== 'all') {
                    params.append('category', selectedCategory);
                }

                try {
                    const response = await fetch(`/transaksi?${params.toString()}`);
                    const data = await response.json();
                    updateTable(data);
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            };

            // Debounced search handler
            const debounce = (func, wait) => {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            };

            const debouncedFetch = debounce(() => fetchData(1), 300);

            // Event listeners for combined filtering
            searchInput.addEventListener('input', debouncedFetch);
            categorySelect.addEventListener('change', () => fetchData(1));

            // Load initial data
            fetchData(1);
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categorySelect = document.getElementById('category');
            const transactionTable = document.getElementById('transaction-table');
            const pagination = document.getElementById('pagination');

            // Function to update the table content
            const updateTable = (data) => {
                const tbody = transactionTable.querySelector('tbody');
                tbody.innerHTML = '';

                if (data.transactions.length === 0) {
                    // Add "no data found" message spanning all columns
                    const columnCount = transactionTable.querySelector('thead tr').childElementCount;
                    const noDataRow = `
                <tr>
                    <td colspan="${columnCount}" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-base font-medium">Data tidak ditemukan</p>
                            <p class="text-sm">Coba ubah filter atau kata kunci pencarian Anda</p>
                        </div>
                    </td>
                </tr>
            `;
                    tbody.insertAdjacentHTML('beforeend', noDataRow);
                    // Hide pagination when no data
                    pagination.style.display = 'none';
                    return;
                }

                // Show pagination when there is data
                pagination.style.display = 'block';

                data.transactions.forEach((trans, index) => {
                    const rowNumber = (data.pagination.current_page - 1) * data.pagination.per_page +
                        index + 1;
                     // Set campaign, zakat, or infak name
                    let nameHTML = '-'; // Default value
                    if (trans.campaign_name) {
                        nameHTML = trans.campaign_name;
                    } else if (trans.zakat_name) {
                        nameHTML = trans.zakat_name;
                    } else if (trans.infak_name) {
                        nameHTML = trans.infak_name;
                    }
                    const row = `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${rowNumber}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.invoice_id}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.category}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${nameHTML}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.donatur}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.phone_number}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.message ? trans.message : '-'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.method}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Rp ${new Intl.NumberFormat('id-ID').format(trans.transaction_amount)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.transaction_date}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                         Rp ${new Intl.NumberFormat('id-ID').format(trans.for_ict)}
                    </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${trans.asal_transaksi ? trans.asal_transaksi : '-'}
                    </td>
                </tr>
            `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });

                // Update pagination
                updatePagination(data.pagination);

                // Update URL with current filters
                updateURL();
            };

            // Function to update pagination
            const updatePagination = (paginationData) => {
                const paginationHtml = `
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">${(paginationData.current_page - 1) * paginationData.per_page + 1}</span>
                        to
                        <span class="font-medium">
                            ${Math.min(paginationData.current_page * paginationData.per_page, paginationData.total)}
                        </span>
                        of
                        <span class="font-medium">${paginationData.total}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        ${generatePaginationButtons(paginationData)}
                    </nav>
                </div>
            </div>
        `;
                pagination.innerHTML = paginationHtml;

                // Reattach click handlers to pagination buttons
                attachPaginationHandlers();
            };

            // Function to generate pagination buttons
            // const generatePaginationButtons = (paginationData) => {
            //     let buttons = '';

            //     // Previous button
            //     if (paginationData.current_page > 1) {
            //         buttons += `
        //     <a href="#" data-page="${paginationData.current_page - 1}" 
        //        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
        //         <span>Previous</span>
        //     </a>
        //     `;
            //     }

            //     // Page numbers
            //     for (let i = 1; i <= paginationData.last_page; i++) {
            //         buttons += `
        //     <a href="#" data-page="${i}"
        //        class="relative inline-flex items-center px-4 py-2 text-sm font-medium ${i === paginationData.current_page 
        //            ? 'bg-indigo-600 text-white' 
        //            : 'text-gray-900'} ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
        //         ${i}
        //     </a>
        //      `;
            //     }

            //     // Next button
            //     if (paginationData.current_page < paginationData.last_page) {
            //         buttons += `
        //     <a href="#" data-page="${paginationData.current_page + 1}"
        //        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
        //         <span>Next</span>
        //     </a>
        //      `;
            //     }

            //     return buttons;
            // };

            // Function to generate pagination buttons with ellipsis
            const generatePaginationButtons = (paginationData) => {
                let buttons = '';
                const currentPage = paginationData.current_page;
                const lastPage = paginationData.last_page;

                // Previous button
                if (currentPage > 1) {
                    buttons += `
            <a href="#" data-page="${currentPage - 1}" 
               class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span>Previous</span>
            </a>
        `;
                }

                // Function to generate button HTML
                const getPageButton = (pageNum, isActive = false) => `
        <a href="#" data-page="${pageNum}"
           class="relative inline-flex items-center px-4 py-2 text-sm font-medium ${
               isActive ? 'bg-indigo-600 text-white' : 'text-gray-900'
           } ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            ${pageNum}
        </a>
        `;

                // Function to add ellipsis
                const addEllipsis = () => `
        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 ring-1 ring-inset ring-gray-300">
            ...
        </span>
    `;

                // Always show first page
                buttons += getPageButton(1, currentPage === 1);

                if (lastPage <= 7) {
                    // If total pages are 7 or less, show all pages
                    for (let i = 2; i < lastPage; i++) {
                        buttons += getPageButton(i, currentPage === i);
                    }
                } else {
                    // Handle cases with more than 7 pages
                    if (currentPage <= 3) {
                        // Near the start
                        buttons += getPageButton(2, currentPage === 2);
                        buttons += getPageButton(3, currentPage === 3);
                        buttons += getPageButton(4, currentPage === 4);
                        buttons += addEllipsis();
                    } else if (currentPage >= lastPage - 2) {
                        // Near the end
                        buttons += addEllipsis();
                        buttons += getPageButton(lastPage - 3, currentPage === lastPage - 3);
                        buttons += getPageButton(lastPage - 2, currentPage === lastPage - 2);
                        buttons += getPageButton(lastPage - 1, currentPage === lastPage - 1);
                    } else {
                        // Somewhere in the middle
                        buttons += addEllipsis();
                        buttons += getPageButton(currentPage - 1);
                        buttons += getPageButton(currentPage, true);
                        buttons += getPageButton(currentPage + 1);
                        buttons += addEllipsis();
                    }
                }

                // Always show last page if there is more than one page
                if (lastPage > 1) {
                    buttons += getPageButton(lastPage, currentPage === lastPage);
                }

                // Next button
                if (currentPage < lastPage) {
                    buttons += `
            <a href="#" data-page="${currentPage + 1}"
               class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span>Next</span>
            </a>
        `;
                }

                return buttons;
            };

            // Function to attach pagination click handlers
            const attachPaginationHandlers = () => {
                const paginationLinks = pagination.querySelectorAll('a[data-page]');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const page = e.currentTarget.dataset.page;
                        fetchData(page);
                    });
                });
            };

            // Function to update URL with current filters
            const updateURL = () => {
                const searchParams = new URLSearchParams(window.location.search);
                const currentSearch = searchInput.value;
                const currentCategory = categorySelect.value;

                if (currentSearch) {
                    searchParams.set('search', currentSearch);
                } else {
                    searchParams.delete('search');
                }

                if (currentCategory !== 'all') {
                    searchParams.set('category', currentCategory);
                } else {
                    searchParams.delete('category');
                }

                const newUrl =
                    `${window.location.pathname}${searchParams.toString() ? '?' + searchParams.toString() : ''}`;
                window.history.pushState({}, '', newUrl);
            };

            // Function to fetch data with combined filters
            const fetchData = async (page = 1) => {
                const searchQuery = searchInput.value;
                const selectedCategory = categorySelect.value;

                const params = new URLSearchParams({
                    page: page,
                    ajax: 1
                });

                if (searchQuery) {
                    params.append('search', searchQuery);
                }

                if (selectedCategory !== 'all') {
                    params.append('category', selectedCategory);
                }

                try {
                    const response = await fetch(`/transaksi?${params.toString()}`);
                    const data = await response.json();
                    updateTable(data);
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            };

            // Debounced search handler
            const debounce = (func, wait) => {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            };

            const debouncedFetch = debounce(() => fetchData(1), 300);

            // Event listeners for combined filtering
            searchInput.addEventListener('input', debouncedFetch);
            categorySelect.addEventListener('change', () => fetchData(1));

            // Load initial data
            fetchData(1);
        });
    </script>
</body>


</html>
