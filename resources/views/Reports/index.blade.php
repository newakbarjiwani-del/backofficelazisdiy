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

    <title>Laporan</title>
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
                                <h1 class="text-2xl font-semibold text-gray-900 mb-4">Laporan</h1>
                                <div class="flex gap-4">
                                    <div>
                                        <label for="month">Bulan:</label>
                                        <select id="month" onchange="window.location.href=this.value"
                                            class="px-1 py-1 rounded-md shadow-md ml-2">
                                            <!-- Default empty option to reset the month -->
                                            <option value="{{ route('reports.index', ['year' => request('year')]) }}">
                                                Pilih
                                                Bulan</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '01', 'year' => request('year')]) }}"
                                                {{ request('month') == '01' ? 'selected' : '' }}>Januari</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '02', 'year' => request('year')]) }}"
                                                {{ request('month') == '02' ? 'selected' : '' }}>Februari</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '03', 'year' => request('year')]) }}"
                                                {{ request('month') == '03' ? 'selected' : '' }}>Maret</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '04', 'year' => request('year')]) }}"
                                                {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '05', 'year' => request('year')]) }}"
                                                {{ request('month') == '05' ? 'selected' : '' }}>Mei</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '06', 'year' => request('year')]) }}"
                                                {{ request('month') == '06' ? 'selected' : '' }}>Juni</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '07', 'year' => request('year')]) }}"
                                                {{ request('month') == '07' ? 'selected' : '' }}>Juli</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '08', 'year' => request('year')]) }}"
                                                {{ request('month') == '08' ? 'selected' : '' }}>Agustus</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '09', 'year' => request('year')]) }}"
                                                {{ request('month') == '09' ? 'selected' : '' }}>September</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '10', 'year' => request('year')]) }}"
                                                {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '11', 'year' => request('year')]) }}"
                                                {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                                            <option
                                                value="{{ route('reports.index', ['month' => '12', 'year' => request('year')]) }}"
                                                {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="year">Tahun:</label>
                                        <select id="year" onchange="window.location.href=this.value"
                                            class="px-1 py-1 rounded-md shadow-md ml-2">
                                            <!-- Default empty option to reset the year -->
                                            <option
                                                value="{{ route('reports.index', ['month' => request('month')]) }}">
                                                Pilih
                                                Tahun</option>
                                            @for ($year = 2000; $year <= 2230; $year++)
                                                <option
                                                    value="{{ route('reports.index', ['year' => $year, 'month' => request('month')]) }}"
                                                    {{ request('year') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div x-data="{ isOpen: false }" class="relative mt-10">

                                <!-- Tombol untuk membuka modal -->
                                <button type="button" @click="isOpen = true"
                                    class="bg-green-600 p-2 rounded-md shadow-md text-white">Upload laporan</button>

                                <div>
                                    @include('Reports.create')
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
                                                Nama file
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                File
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal upload
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @if (count($reports) > 0)
                                            @forelse ($reports as $index => $report)
                                                @php
                                                    $globalIndex = $index + 1;
                                                @endphp
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $globalIndex }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $report['title'] }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <a href="{{ $report['file_url'] }}" target="_blank"
                                                            data-id="{{ $report['id'] }}">
                                                            <img src="{{ asset('assets/img/doc.svg') }}"
                                                                alt="PDF Preview" class="w-7 h-7">
                                                        </a>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $report['created_at'] }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                        <div
                                                            class="flex flex-col items-center justify-center space-y-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-8 w-8 text-gray-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <p class="text-gray-500">
                                                                @if (request('month') && request('year'))
                                                                    Tidak ada data ditemukan untuk pencarian bulan ke
                                                                    <strong>"{{ request('month') }}"</strong> pada
                                                                    tahun
                                                                    <strong>"{{ request('year') }}"</strong>.
                                                                @elseif (request('month'))
                                                                    Tidak ada data ditemukan untuk pencarian bulan ke
                                                                    <strong>"{{ request('month') }}"</strong>.
                                                                @elseif (request('year'))
                                                                    Tidak ada data ditemukan untuk kategori pada tahun
                                                                    <strong>"{{ request('year') }}"</strong>.
                                                                @else
                                                                    Data yang anda cari atau filter tidak ditemukan.
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
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


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("reportsform");
            const fileNameInput = document.getElementById("file_name");
            const fileInput = document.getElementById("file");
            const errorMessage = document.getElementById("errorMessage");
            const fileError = document.getElementById("file-error");
            const fileNameDisplay = document.getElementById("fileName");
            const fileInfoContainer = document.getElementById("fileInfo");
            const resetButton = document.getElementById("resetButton");
            const submitButton = form.querySelector('[type="submit"]');
            const maxFileSize = 2; // Maksimal ukuran file dalam MB

            // Fungsi untuk menampilkan atau menyembunyikan tombol submit
            function toggleSubmitButton(enable) {
                if (enable) {
                    submitButton.disabled = false;
                    submitButton.classList.remove("bg-gray-400", "cursor-not-allowed");
                    submitButton.classList.add("bg-green-600", "hover:bg-green-700");
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.remove("bg-green-600", "hover:bg-green-700");
                    submitButton.classList.add("bg-gray-400", "cursor-not-allowed");
                }
            }

            // Validasi input nama file
            function validateFileName() {
                const value = fileNameInput.value.trim();
                if (!value) {
                    errorMessage.textContent = "Nama file tidak boleh kosong.";
                    errorMessage.classList.remove("hidden");
                    toggleSubmitButton(false);
                    return false;
                } else {
                    errorMessage.classList.add("hidden");
                    return true;
                }
            }

            // Validasi ukuran file
            function validateFileSize(file) {
                const fileSize = file.size / 1024 / 1024; // Konversi ke MB
                if (fileSize > maxFileSize) {
                    fileError.textContent = `Ukuran file tidak boleh lebih dari ${maxFileSize}MB!`;
                    fileError.classList.remove("hidden");
                    toggleSubmitButton(false);
                    return false;
                } else {
                    fileError.classList.add("hidden");
                    return true;
                }
            }

            // Event listener untuk input nama file
            fileNameInput.addEventListener("input", () => {
                validateFileName();
            });

            // Event listener untuk file input
            fileInput.addEventListener("change", function() {
                const file = this.files[0];
                if (file) {
                    if (validateFileSize(file)) {
                        fileNameDisplay.textContent = `File terpilih: ${file.name}`;
                        fileInfoContainer.classList.remove("hidden");
                        toggleSubmitButton(true);
                    } else {
                        fileInfoContainer.classList.add("hidden");
                    }
                } else {
                    fileInfoContainer.classList.add("hidden");
                }
            });

            // Tombol reset file
            resetButton.addEventListener("click", function() {
                fileInput.value = "";
                fileNameDisplay.textContent = "File terpilih: Tidak ada file";
                fileInfoContainer.classList.add("hidden");
                toggleSubmitButton(false);
            });

            // Validasi akhir sebelum submit
            form.addEventListener("submit", function(event) {
                if (!validateFileName() || fileInput.files.length === 0 || !validateFileSize(fileInput
                        .files[0])) {
                    event.preventDefault();
                    alert("Pastikan semua input valid sebelum mengirim formulir.");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        function submitForm() {
            // Ambil bulan dan tahun dari input
            const date = document.getElementById('month').value;

            // Jika ada tanggal yang dipilih
            if (date) {
                // Ubah input bulan menjadi bulan dan tahun dalam format yang diinginkan
                const [year, month] = date.split('-');

                // Set nilai input month dan year pada form
                const form = document.getElementById('reportForm');
                form.querySelector('[name="month"]').value = month;
                form.querySelector('[name="year"]').value = year;

                // Submit form secara otomatis
                form.submit();
            }
        }
    </script>
</body>

</html>
