<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <div class="bg-white col-span-3 rounded-md mt-2 mx-2 shadow-xl">
                    <div class="mx-5">
                        <div class="flex justify-between items-center mb-6">
                            <div class="mt-2">
                                <h1 class="text-2xl font-semibold text-gray-900">Kategori Campaign</h1>
                                {{-- <div class="relative mt-5">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="searchInput"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="cari nama campaign...">
                                </div> --}}
                            </div>

                            <div x-data="{ isOpen: false }" class="relative mt-10">

                                <!-- Tombol untuk membuka modal -->
                                <button type="button" @click="isOpen = true"
                                    class="bg-green-600 p-2 rounded-md shadow-md text-white">Buat Campaign</button>

                                <!-- Modal -->
                                <div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="fixed inset-0 z-20 flex items-center justify-center"
                                    aria-labelledby="modal-title" role="dialog" aria-modal="true">

                                    <!-- Backdrop -->
                                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"
                                        @click="isOpen = false"></div>

                                    <!-- Modal content -->
                                    <div
                                        class="ml-56 mt-14 relative h-72 bg-white rounded-lg shadow-xl w-full max-w-md p-6 overflow-hidden transform transition-all">
                                        <!-- Header -->
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-medium text-gray-900 mb-3" id="modal-title">Buat
                                                kategori Campaign
                                            </h3>
                                            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Close</span>
                                                &#10005;
                                            </button>
                                        </div>

                                        <!-- Formulir Campaign -->
                                        <form id="categoryForm" action="{{ route('campaignCategory.store') }}"
                                            method="POST" class="overflow-y-auto">
                                            @csrf
                                            <div>
                                                <!-- Nama kategori Campaign -->
                                                <div>
                                                    <label for="campaign_category"
                                                        class="block text-sm font-medium text-gray-700 mb-2">Nama
                                                        kategori campaign</label>
                                                    <input type="text" name="campaign_category"
                                                        id="campaign_category"
                                                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                                                        placeholder="Masukkan kategori campaign..." required>
                                                    <p id="errorMessage" class="text-red-500 text-sm mt-1 hidden">
                                                        Kategori ini sudah ada.</p>
                                                </div>
                                            </div>

                                            <!-- Tombol Batal dan Simpan -->
                                            <div class="flex flex-col mt-6 space-y-3 mb-5">
                                                <button type="button" @click="isOpen = false"
                                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                                    Batal
                                                </button>
                                                <button type="submit" id="submitButton"
                                                    class="inline-flex justify-center w-full rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-green-700">
                                                    Simpan
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="overflow-auto w-full">
                            <div class="max-h-[calc(100vh-240px)] overflow-y-auto">
                                <table id="transaction-table" class="min-w-full bg-white table-auto overflow-x-auto">
                                    <thead class="sticky top-0 z-10">
                                        <!-- Table Header -->
                                        <tr>
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
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($campaignsCategory as $index => $categories)
                                            @php
                                                $globalIndex = $index + 1;
                                            @endphp
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $categories['campaign_category'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <div x-data="{ isOpen: false }">
                                                            <button class="text-yellow-800" type="button"
                                                            value="{{ $categories['id'] }}" @click="isOpen = true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                            <div>
                                                                @include('campaign.editCategory')
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        </main>
    </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('categoryForm');
            const formEdit = document.getElementById('EditCategoryCampaign-form');
            const input = document.getElementById('campaign_category');
            const inputEdit = document.getElementById('Editcampaign_category');
            const errorMessage = document.getElementById('errorMessage');
            const submitButton = document.getElementById('submitButton');

            function disableSubmit() {
                submitButton.disabled = true;
                submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            }

            function enableSubmit() {
                submitButton.disabled = false;
                submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
            }

            function validateInput(value) {
                if (!value.trim()) {
                    errorMessage.textContent = 'Nama kategori tidak boleh kosong.';
                    errorMessage.classList.remove('hidden');
                    disableSubmit();
                    return false;
                }
                return true;
            }

            input.addEventListener('input', debounce(function() {
                const campaignCategory = this.value;

                if (!validateInput(campaignCategory)) {
                    return;
                }

                fetch('{{ route('campaignCategory.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            campaign_category: campaignCategory.trim()
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.exists) {
                            errorMessage.textContent = data.message;
                            errorMessage.classList.remove('hidden');
                            disableSubmit();
                        } else {
                            errorMessage.classList.add('hidden');
                            enableSubmit();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorMessage.textContent = 'Terjadi kesalahan saat memeriksa kategori.';
                        errorMessage.classList.remove('hidden');
                        enableSubmit();
                    });
            }, 300));

            form.addEventListener('submit', function(e) {
                const campaignCategory = input.value;

                if (!validateInput(campaignCategory)) {
                    e.preventDefault();
                    return;
                }

                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }
            });
            inputEdit.addEventListener('input', debounce(function() {
                const campaignCategory = this.value;

                if (!validateInput(campaignCategory)) {
                    return;
                }

                fetch('{{ route('campaignCategory.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            campaign_category: campaignCategory.trim()
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.exists) {
                            errorMessage.textContent = data.message;
                            errorMessage.classList.remove('hidden');
                            disableSubmit();
                        } else {
                            errorMessage.classList.add('hidden');
                            enableSubmit();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorMessage.textContent = 'Terjadi kesalahan saat memeriksa kategori.';
                        errorMessage.classList.remove('hidden');
                        enableSubmit();
                    });
            }, 300));

            formEdit.addEventListener('submit', function(e) {
                const campaignCategory = input.value;

                if (!validateInput(campaignCategory)) {
                    e.preventDefault();
                    return;
                }

                if (submitButton.disabled) {
                    e.preventDefault();
                    return;
                }
            });
        });

        function debounce(callback, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => callback.apply(this, args), delay);
            };
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

</body>

</html>
