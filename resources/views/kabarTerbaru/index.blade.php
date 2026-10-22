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
                <div class="bg-white col-span-3 rounded-md mt-2 mx-2 shadow-xl">
                    <div class="mx-5">
                        <div class="flex justify-between items-center mb-6">
                            <div class="mt-2">
                                <h1 class="text-2xl font-semibold text-gray-900">Kabar Terbaru</h1>
                            </div>

                        </div>
                        <div class="overflow-auto w-full">
                            <div class="max-h-[calc(100vh-12rem)] overflow-y-auto">
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
                                                category
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                name
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b text-center border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Image
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Deskripsi
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b text-center border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @if ($newss->count() > 0)
                                            @foreach ($newss as $index => $news)
                                                @php
                                                    $globalIndex = $index + 1;
                                                @endphp
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $globalIndex }}
                                                    </td>
                                                    <td class="px-6 py-4 w-32 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $news['category'] }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm  text-gray-500 text-wrap truncate overflow-hidden">
                                                        {{ $news['campaign_name'] }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $news['latest_news_date'] }}</td>

                                                    <!-- Gambar di dalam tabel, menggunakan class dan data-image -->
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <img src="{{ $news['image'] }}" alt="Image"
                                                            class="w-96 h-auto rounded-md cursor-pointer imageModalTrigger"
                                                            data-image="{{ $news['image'] }}">
                                                    </td>

                                                    <!-- Modal untuk menampilkan gambar besar -->
                                                    <div id="imageModal"
                                                        class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
                                                        <div
                                                            class="relative w-full h-full flex items-center justify-center">
                                                            <span id="closeModal"
                                                                class="absolute top-2 right-2 text-white text-3xl cursor-pointer">&times;</span>
                                                            <img id="modalImage" src="" alt="Full Image"
                                                                class="max-w-6xl max-h-[calc(100vh-5rem)] object-contain">
                                                        </div>
                                                    </div>


                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-ellipsis text-sm line-clamp-3 text-wrap text-justify text-gray-500">
                                                        {!! $news['description'] !!}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <div class="flex items-center gap-2">
                                                            <div x-data="{ isOpen: false }">
                                                                <button class="text-yellow-800" type="button"
                                                                    value="{{ $news['id'] }}" @click="isOpen = true">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="w-5">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                    </svg>
                                                                </button>
                                                                <div>
                                                                    @include('kabarTerbaru.edit')
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <form
                                                                    action="{{ route('news.destroy', ['id' => $news['id']]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button"
                                                                        onclick="confirmToggleDelete(this, '{{ $news['id'] }}')"
                                                                        class="text-red-700">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="size-6">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                        </svg>

                                                                    </button>
                                                                </form>

                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    <div class="flex flex-col items-center justify-center space-y-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-8 w-8 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <p class="text-gray-500">
                                                           Tidak ada data yang tersedia
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        // Ambil semua elemen gambar dengan kelas 'imageModalTrigger'
        const images = document.querySelectorAll('.imageModalTrigger');
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeModal = document.getElementById('closeModal');

        // Loop melalui semua gambar dan tambahkan event listener
        images.forEach(image => {
            image.addEventListener('click', function() {
                const imageSrc = image.getAttribute(
                    'data-image'); // Ambil src gambar dari atribut data-image
                modal.classList.remove('hidden'); // Tampilkan modal
                modalImage.src = imageSrc; // Set gambar modal menjadi gambar yang diklik
            });
        });

        // Ketika tombol close modal diklik, sembunyikan modal
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Menutup modal jika area luar gambar diklik
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>
    <script>
        function confirmToggleDelete(button, newsid) {
            if (!button) return;

            Swal.fire({
                title: `Apakah Anda yakin?`,
                html: `Anda ingin menghapus news dengan id:<b><i>"${newsid}"</i></b>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = button.closest('form');
                    if (form) form.submit();
                }
            });
        }
    </script>


</body>

</html>
