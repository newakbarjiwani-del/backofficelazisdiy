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

    <title>Zakat</title>
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
                                <h1 class="text-2xl font-semibold text-gray-900">Zakat</h1>
                            </div>

                            <div x-data="{ isOpen: false }" class="relative mt-10">

                                <!-- Tombol untuk membuka modal -->
                                <button type="button" @click="isOpen = true"
                                    class="bg-green-600 p-2 rounded-md shadow-md text-white">Buat Zakat</button>

                                <div>
                                    @include('Zakat.create')
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
                                                Zakat
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Terkumpul
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Distribusi
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($zakats as $index => $zakat)
                                            @php
                                                $globalIndex = $index + 1;
                                            @endphp
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $zakat['category_name'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($zakat['amount'], 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($zakat['distribution'], 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <div x-data="{ isOpen: false }">
                                                            <button class="text-yellow-800" type="button"
                                                                value="{{ $zakat['id'] }}" @click="isOpen = true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                            <div>
                                                                @include('Zakat.edit')
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
            const form = document.getElementById('zakatForm');
            const input = document.getElementById('category_name');
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
                    errorMessage.textContent = 'Nama kategori zakat tidak boleh kosong.';
                    errorMessage.classList.remove('hidden');
                    disableSubmit();
                    return false;
                }
                return true;
            }

            input.addEventListener('input', debounce(function() {
                const zakatCategory = this.value;

                if (!validateInput(zakatCategory)) {
                    return;
                }

                fetch('{{ route('zakat.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            category_name: zakatCategory.trim()
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
                const zakatCategory = input.value;

                if (!validateInput(zakatCategory)) {
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
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("zakatForm");
            const fileInputs = ["thumbnail"];

            // Tambahkan event listener ke setiap file input
            fileInputs.forEach((fileInputId) => {
                const fileInput = document.getElementById(fileInputId);
                if (fileInput) {
                    const previewImg = document.getElementById(`${fileInputId}Preview`);
                    const errorElement = document.getElementById(`${fileInputId}-error`);
                    const previewContainer = document.getElementById("previewContainer");

                    // Event untuk validasi dan preview
                    fileInput.addEventListener("change", function() {
                        validateAndPreviewFile(fileInputId, previewImg, errorElement,
                            previewContainer);
                    });

                    // Tombol reset
                    const resetButton = document.getElementById("resetButton");
                    resetButton.addEventListener("click", function() {
                        resetFile(fileInput, previewImg, previewContainer, errorElement);
                    });
                }
            });

            // Fungsi validasi ukuran file dan menampilkan preview
            function validateAndPreviewFile(fileInputId, previewImg, errorElement, previewContainer) {
                const fileInput = document.getElementById(fileInputId);
                const maxFileSize = 2; // Ukuran maksimal dalam MB

                if (fileInput && fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileSize = file.size / 1024 / 1024; // Konversi ke MB

                    // Validasi ukuran file
                    if (fileSize > maxFileSize) {
                        // Tampilkan pesan error jika file terlalu besar
                        errorElement.textContent = `Ukuran file tidak boleh lebih dari ${maxFileSize}MB!`;
                        errorElement.classList.remove("hidden");
                        previewContainer.classList.add("hidden");
                        fileInput.value = ''; // Reset file input
                        return false;
                    } else {
                        // Sembunyikan pesan error jika file valid
                        errorElement.classList.add("hidden");

                        // Tampilkan preview gambar
                        const objectUrl = URL.createObjectURL(file);
                        previewImg.src = objectUrl;
                        previewContainer.classList.remove("hidden");

                        // Bersihkan URL objek saat gambar dimuat
                        previewImg.onload = () => {
                            URL.revokeObjectURL(objectUrl);
                        };

                        return true;
                    }
                } else {
                    // Sembunyikan preview jika tidak ada file
                    previewContainer.classList.add("hidden");
                }
                return true;
            }

            // Fungsi untuk mereset file input dan preview
            function resetFile(fileInput, previewImg, previewContainer, errorElement) {
                fileInput.value = ''; // Reset file input
                previewImg.src = '#'; // Kosongkan gambar
                previewContainer.classList.add("hidden"); // Sembunyikan kontainer preview
                errorElement.classList.add("hidden"); // Sembunyikan error
            }

            // Handler untuk submit form
            form.addEventListener("submit", function(event) {
                let isValid = true;

                // Validasi setiap file input
                fileInputs.forEach((fileInputId) => {
                    const fileInput = document.getElementById(fileInputId);
                    const previewImg = document.getElementById(`${fileInputId}Preview`);
                    const errorElement = document.getElementById(`${fileInputId}-error`);
                    const previewContainer = document.getElementById("previewContainer");

                    if (fileInput && (fileInput.hasAttribute('required') || fileInput.files.length >
                            0)) {
                        if (!validateAndPreviewFile(fileInputId, previewImg, errorElement,
                                previewContainer)) {
                            isValid = false;
                        }
                    }
                });

                // Cegah pengiriman form jika validasi gagal
                if (!isValid) {
                    event.preventDefault();
                    alert("Form tidak dapat dikirim. Pastikan semua file berukuran kurang dari 2MB.");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

</body>

</html>
