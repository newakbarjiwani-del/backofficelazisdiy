<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- @vite('resources/css/app.css') --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">


    <title>Campaign</title>
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
                                <h1 class="text-2xl font-semibold text-gray-900 mt-2 py-2">Campaign Rekomendasi</h1>
                                <div class="mt-2">
                                    <div class="relative mt-5 flex">
                                        {{-- <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </div> --}}
                                        {{-- <input type="text" name="search" id="searchInput"
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
                                        </div> --}}

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
                                                class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Rekomendasi
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Penggalang Dana
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
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($campaigns as $index => $campaign)
                                            @php
                                                $globalIndex = $index + 1;
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if ($campaign['recomendation'] == 1)
                                                        <form
                                                            action="{{ route('unrecomendation.index', ['id' => $campaign['id']]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button"
                                                                onclick="confirmToggleRecomendation(this, 'unset', '{{ $campaign['campaign_name'] }}')"
                                                                class="inline-flex items-center rounded-md bg-blue-50 ring-1 ring-inset ring-blue-600/20 font-extrabold text-blue-600 px-2 py-1 text-xs">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form
                                                            action="{{ route('setrecomendation.index', ['id' => $campaign['id']]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button"
                                                                onclick="confirmToggleRecomendation(this, 'set', '{{ $campaign['campaign_name'] }}')"
                                                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $campaign['fundraiser'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $campaign['category_name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $campaign['campaign_name'] }}</td>
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
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <div x-data="{ isOpen: false }">
                                                            <button class="text-yellow-800" type="button"
                                                                value="{{ $campaign['id'] }}" @click="isOpen = true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                            <div>
                                                                @include('campaign.editCampaign')
                                                            </div>
                                                        </div>

                                                    </div>
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
                        {{-- <div id="pagination"
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
                        </div> --}}
                    </div>
                </div>

        </div>
        </main>
    </div>
    </div>

    <script>
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
    </script>
    <script>
        function confirmToggleRecomendation(button, action, campaignName) {
            Swal.fire({
                title: `Apakah Anda yakin?`,
                html: `Anda ingin menonaktifkan rekomendasi campaign <b><i>"${campaignName}"</i></b>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Temukan form terkait tombol dan submit
                    const form = button.closest('form');
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>
