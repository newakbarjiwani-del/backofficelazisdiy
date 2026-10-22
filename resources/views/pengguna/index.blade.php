<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    <title>Pengguna</title>
</head>

<body class="h-screen bg-gray-100">
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
                    <div class="mx-10">
                        <div class="flex justify-between items-center mb-6">
                            <div class="mt-2">
                                <h1 class="text-2xl font-semibold text-gray-900">Pengguna</h1>

                            </div>
                            <!-- Form Pencarian -->
                            <div class="relative mt-10 w-60">
                                <!-- Ikon di dalam input -->
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <!-- SVG Ikon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>

                                </div>
                                <!-- Input field -->
                                <input type="text" name="search" id="searchInput"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="cari nama pengguna..." value="{{ request('search') }}">
                            </div>

                        </div>
                        <div class="overflow-x-auto">
                            <div class="max-h-[calc(100vh-270px)] overflow-y-auto">
                                <table class="min-w-full overflow-auto bg-white">
                                    <thead class="sticky top-0 z-10">
                                        <tr>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No</th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <a
                                                    href="{{ request()->fullUrlWithQuery(['sortField' => 'name', 'sortDirection' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                    Nama
                                                    @if ($sortField === 'name')
                                                        @if ($sortDirection === 'asc')
                                                            ▲
                                                        @else
                                                            ▼
                                                        @endif
                                                    @endif
                                                </a>
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Email</th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No Hp</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($users as $index => $user)
                                            @php
                                                $globalIndex =
                                                    ($pagination['current_page'] - 1) * $pagination['per_page'] +
                                                    $index +
                                                    1;
                                            @endphp
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user['name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user['email'] ?? 'Email not available' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user['phone_number'] }}</td>
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
                                                            @if (request('search'))
                                                                Tidak ada data ditemukan untuk pecarian
                                                                <strong>"{{ request('search') }}"</strong>
                                                            @else
                                                                Data yang anda cari tidak ditemukan.
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div
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
                                    @php
                                        function getCondensedPageNumbers($currentPage, $lastPage)
                                        {
                                            // If total pages are 10 or less, show all pages
                                            if ($lastPage <= 10) {
                                                return range(1, $lastPage);
                                            }

                                            $pageNumbers = [];

                                            // Always show first page
                                            $pageNumbers[] = 1;

                                            // Add ellipsis if current page is far from first page
                                            if ($currentPage > 5) {
                                                $pageNumbers[] = '...';
                                            }

                                            // Determine range of pages to show around current page
                                            $start = max(2, $currentPage - 2);
                                            $end = min($lastPage - 1, $currentPage + 2);

                                            for ($i = $start; $i <= $end; $i++) {
                                                if (!in_array($i, $pageNumbers)) {
                                                    $pageNumbers[] = $i;
                                                }
                                            }

                                            // Add ellipsis if needed
                                            if ($currentPage < $lastPage - 4) {
                                                if (!in_array('...', $pageNumbers)) {
                                                    $pageNumbers[] = '...';
                                                }
                                            }

                                            // Always show last page
                                            if (!in_array($lastPage, $pageNumbers)) {
                                                $pageNumbers[] = $lastPage;
                                            }

                                            return $pageNumbers;
                                        }

                                        $condensedPages = getCondensedPageNumbers(
                                            $pagination['current_page'],
                                            $pagination['last_page'],
                                        );
                                    @endphp

                                    <div class="w-full flex justify-end">
                                        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm max-w-md"
                                            aria-label="Pagination">
                                            <!-- Tombol Previous -->
                                            @if ($pagination['current_page'] > 1)
                                                <a href="?page={{ $pagination['current_page'] - 1 }}"
                                                    class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor"
                                                        aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @endif

                                            <!-- Tombol Nomor Halaman -->
                                            @foreach ($condensedPages as $page)
                                                @if ($page === '...')
                                                    <span
                                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">
                                                        ...
                                                    </span>
                                                @else
                                                    <a href="?page={{ $page }}"
                                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 {{ $page == $pagination['current_page'] ? 'bg-indigo-600 text-white' : '' }}">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach

                                            <!-- Tombol Next -->
                                            @if ($pagination['current_page'] < $pagination['last_page'])
                                                <a href="?page={{ $pagination['current_page'] + 1 }}"
                                                    class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                    <span class="sr-only">Next</span>
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

    {{-- <script>
        let searchTimer;
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.querySelector('tbody');
        const paginationContainer = document.querySelector('[aria-label="Pagination"]').parentElement.parentElement;
        const loadingIndicator = document.createElement('tr');

        // Create loading indicator element
        loadingIndicator.innerHTML = `
            <td colspan="4" class="px-6 py-8">
                <div class="flex justify-center items-center space-y-2 w-full">
                    <svg class="animate-spin h-5 w-5 mr-3 text-gray-500" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Searching...
                </div>
            </td>
        `;

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                fetchUsers(e.target.value);
            }, 300); // 300ms debounce
        });

        async function fetchUsers(searchTerm, page = 1) {
            try {
                tableBody.innerHTML = loadingIndicator.innerHTML;
                const currentUrl = new URL(window.location.href);
                const sortField = currentUrl.searchParams.get('sortField') || 'name';
                const sortDirection = currentUrl.searchParams.get('sortDirection') || 'asc';

                const response = await fetch(
                    `/users/search?search=${searchTerm}&page=${page}&sortField=${sortField}&sortDirection=${sortDirection}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                const data = await response.json();
                updateTable(data.users, data.pagination);
                updatePagination(data.pagination);

                // Update URL without refreshing page
                const url = new URL(window.location.href);
                url.searchParams.set('search', searchTerm);
                url.searchParams.set('page', page);
                window.history.pushState({}, '', url);
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function updateTable(users, pagination) {
            let html = '';
            if (users.length === 0) {
                // Tampilkan pesan ketika tidak ada data yang ditemukan
                html = `
     <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
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
            } else {
                users.forEach((user, index) => {
                    const globalIndex = (pagination.current_page - 1) * pagination.per_page + index + 1;
                    html += `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${globalIndex}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.name || 'Nama tidak ada'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email || 'Email tidak ada'}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.phone_number || 'No HP tidak ada'}</td>
        </tr>
      `;
                });
            }
            tableBody.innerHTML = html;
        }


        //     function updatePagination(pagination) {
        //         const startIndex = (pagination.current_page - 1) * pagination.per_page + 1;
        //         const endIndex = Math.min(pagination.current_page * pagination.per_page, pagination.total);

        //         let paginationHtml = `
        //     <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        //         <div>
        //             <p class="text-sm text-gray-700">
        //                 Showing <span class="font-medium">${startIndex}</span> to
        //                 <span class="font-medium">${endIndex}</span> of
        //                 <span class="font-medium">${pagination.total}</span> results
        //             </p>
        //         </div>
        //         <div>
        //             <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        //     `;

            //         // Previous button
            //         if (pagination.current_page > 1) {
            //             paginationHtml += `
        //     <a href="#" onclick="fetchUsers('${searchInput.value}', ${pagination.current_page - 1}); return false;"
        //         class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
        //         <span>Previous</span>
        //         <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        //             <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
        //         </svg>
        //     </a>
        //   `;
            //         }

            //         // Page numbers
            //         for (let i = 1; i <= pagination.last_page; i++) {
            //             paginationHtml += `
        //     <a href="#" onclick="fetchUsers('${searchInput.value}', ${i}); return false;"
        //         class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 ${i === pagination.current_page ? 'bg-indigo-600 text-white' : ''}">
        //         ${i}
        //     </a>
        //  `;
            //         }

            //         // Next button
            //         if (pagination.current_page < pagination.last_page) {
            //             paginationHtml += `
        //     <a href="#" onclick="fetchUsers('${searchInput.value}', ${pagination.current_page + 1}); return false;"
        //         class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
        //         <span>Next</span>
        //         <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        //             <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        //         </svg>
        //     </a>
        //     `;
            //         }

            //         paginationHtml += `
        //         </nav>
        //     </div>
        //     </div>
        //     `;

            //         paginationContainer.innerHTML = paginationHtml;
        //     }
        function updatePagination(pagination) {
            const startIndex = (pagination.current_page - 1) * pagination.per_page + 1;
            const endIndex = Math.min(pagination.current_page * pagination.per_page, pagination.total);

            let paginationHtml = `
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">${startIndex}</span> to
                    <span class="font-medium">${endIndex}</span> of
                    <span class="font-medium">${pagination.total}</span> results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        `;

            // Previous button
            if (pagination.current_page > 1) {
                paginationHtml += `
            <a href="#" onclick="fetchUsers('${searchInput.value}', ${pagination.current_page - 1}); return false;"
                class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
            </a>
        `;
            }

            // Condensed page number display logic
            function getCondensedPageNumbers(currentPage, totalPages) {
                // If total pages are 10 or less, show all pages
                if (totalPages <= 10) {
                    return Array.from({
                        length: totalPages
                    }, (_, i) => i + 1);
                }

                const pageNumbers = [];

                // Always show first page
                pageNumbers.push(1);

                // Add ellipsis if current page is far from first page
                if (currentPage > 5) {
                    pageNumbers.push('...');
                }

                // Determine range of pages to show around current page
                const start = Math.max(2, currentPage - 2);
                const end = Math.min(totalPages - 1, currentPage + 2);

                for (let i = start; i <= end; i++) {
                    if (!pageNumbers.includes(i)) {
                        pageNumbers.push(i);
                    }
                }

                // Add ellipsis if needed
                if (currentPage < totalPages - 4) {
                    if (!pageNumbers.includes('...')) {
                        pageNumbers.push('...');
                    }
                }

                // Always show last page
                if (!pageNumbers.includes(totalPages)) {
                    pageNumbers.push(totalPages);
                }

                return pageNumbers;
            }

            // Generate pagination buttons
            const condensedPages = getCondensedPageNumbers(pagination.current_page, pagination.last_page);

            condensedPages.forEach(page => {
                if (page === '...') {
                    paginationHtml += `
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">
                    ...
                </span>
            `;
                } else {
                    paginationHtml += `
                <a href="#" onclick="fetchUsers('${searchInput.value}', ${page}); return false;"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 ${page === pagination.current_page ? 'bg-indigo-600 text-white' : ''}">
                    ${page}
                </a>
            `;
                }
            });

            // Next button
            if (pagination.current_page < pagination.last_page) {
                paginationHtml += `
            <a href="#" onclick="fetchUsers('${searchInput.value}', ${pagination.current_page + 1}); return false;"
                class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Next</span>
                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </a>
        `;
            }

            paginationHtml += `
            </nav>
        </div>
     </div>
     `;

            paginationContainer.innerHTML = paginationHtml;
        }
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');


            // Fungsi untuk mengupdate URL berdasarkan input
            const updateUrl = () => {
                const baseUrl = window.location.origin + window.location.pathname;
                const search = searchInput.value.trim();

                // Buat query string
                const params = new URLSearchParams();
                if (search) params.append('search', search);


                // Redirect ke URL baru
                window.location.href = `${baseUrl}?${params.toString()}`;
            };

            /// Event listener untuk input pencarian
            searchInput.addEventListener('input', () => {
                // Tambahkan delay agar tidak reload setiap karakter
                setTimeout(updateUrl, 300);
            });

            // // Event listener untuk dropdown kategori
            // categoryDropdown.addEventListener('change', updateUrl);
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
