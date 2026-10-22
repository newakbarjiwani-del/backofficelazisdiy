<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Laporan</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
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

            <main class="p-4 max-w-5xl mx-auto">
                <div class="bg-white col-span-3 rounded-md mt-2 mx-2 shadow-xl">
                    <div class="mx-5">
                        <div class="flex justify-between items-center mb-6 pt-4">
                            <div>
                                <h1 class="text-2xl font-semibold text-gray-900">Laporan Keuangan</h1>
                                <p class="text-sm text-gray-500 mt-1">Upload judul, thumbnail, dan file PDF laporan.</p>
                            </div>
                            <div x-data="{ isOpen: false }" class="relative">
                                <button type="button" @click="isOpen = true"
                                    class="bg-green-600 p-2 rounded-md shadow-md text-white">Upload laporan</button>
                                <div>
                                    @include('Reports.create')
                                </div>
                            </div>
                        </div>

                        <div class="overflow-auto w-full pb-6">
                            <div class="max-h-[calc(100vh-240px)] overflow-y-auto">
                                <table class="min-w-full bg-white table-auto">
                                    <thead class="sticky top-0 z-10">
                                        <tr>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Thumbnail
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Judul
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Sumber
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal upload
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @if (count($reports) > 0)
                                            @foreach ($reports as $index => $report)
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        @if (!empty($report['thumbnail_url']))
                                                            <img src="{{ $report['thumbnail_url'] }}"
                                                                alt="{{ $report['title'] }}"
                                                                class="w-16 h-20 object-cover rounded border border-gray-200">
                                                        @else
                                                            <span class="text-xs text-gray-400">Belum ada</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">
                                                        {{ $report['title'] }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        @if (!empty($report['file_url']))
                                                            <a href="{{ $report['file_url'] }}" target="_blank"
                                                                class="inline-flex items-center gap-1 text-orange-600 hover:underline"
                                                                data-id="{{ $report['id'] }}">
                                                                @if (($report['source_label'] ?? '') === 'Google Drive')
                                                                    <span class="text-xs font-semibold">Drive</span>
                                                                @else
                                                                    <img src="{{ asset('assets/img/doc.svg') }}"
                                                                        alt="PDF" class="w-7 h-7">
                                                                @endif
                                                            </a>
                                                        @else
                                                            <span class="text-xs text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $report['created_at'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                                    Belum ada laporan. Silakan unggah laporan baru.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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
            if (!form) return;

            const fileNameInput = document.getElementById("file_name");
            const thumbnailInput = document.getElementById("thumbnail");
            const thumbnailPreview = document.getElementById("thumbnailPreview");
            const driveLinkInput = document.getElementById("drive_link");
            const driveError = document.getElementById("drive-error");
            const fileInput = document.getElementById("file");
            const errorMessage = document.getElementById("errorMessage");
            const thumbnailError = document.getElementById("thumbnail-error");
            const fileError = document.getElementById("file-error");
            const fileNameDisplay = document.getElementById("fileName");
            const fileInfoContainer = document.getElementById("fileInfo");
            const resetButton = document.getElementById("resetButton");
            const submitButton = form.querySelector('[type="submit"]');
            const maxPdfSize = 10;
            const maxImageSize = 2;

            function toggleSubmitButton(enable) {
                submitButton.disabled = !enable;
                submitButton.classList.toggle("bg-gray-400", !enable);
                submitButton.classList.toggle("cursor-not-allowed", !enable);
                submitButton.classList.toggle("bg-green-600", enable);
                submitButton.classList.toggle("hover:bg-green-700", enable);
            }

            function validateTitle() {
                const value = fileNameInput.value.trim();
                if (!value) {
                    errorMessage.classList.remove("hidden");
                    return false;
                }
                errorMessage.classList.add("hidden");
                return true;
            }

            function validateImage(file) {
                if (!file) {
                    thumbnailError.textContent = "Thumbnail wajib diunggah.";
                    thumbnailError.classList.remove("hidden");
                    return false;
                }
                const sizeMb = file.size / 1024 / 1024;
                if (sizeMb > maxImageSize) {
                    thumbnailError.textContent = `Ukuran thumbnail tidak boleh lebih dari ${maxImageSize}MB!`;
                    thumbnailError.classList.remove("hidden");
                    return false;
                }
                thumbnailError.classList.add("hidden");
                return true;
            }

            function isDriveLink(url) {
                try {
                    const host = new URL(url).hostname.toLowerCase();
                    return host.includes("drive.google.com") || host.includes("docs.google.com");
                } catch (error) {
                    return false;
                }
            }

            function validateDriveOrPdf() {
                const driveLink = driveLinkInput.value.trim();
                const pdfFile = fileInput.files[0];

                if (pdfFile) {
                    const sizeMb = pdfFile.size / 1024 / 1024;
                    if (sizeMb > maxPdfSize) {
                        fileError.textContent = `Ukuran PDF tidak boleh lebih dari ${maxPdfSize}MB!`;
                        fileError.classList.remove("hidden");
                        driveError.classList.add("hidden");
                        return false;
                    }
                    fileError.classList.add("hidden");
                } else {
                    fileError.classList.add("hidden");
                }

                if (driveLink) {
                    if (!isDriveLink(driveLink)) {
                        driveError.textContent = "Link harus berupa URL Google Drive yang valid.";
                        driveError.classList.remove("hidden");
                        return false;
                    }
                    driveError.classList.add("hidden");
                    return true;
                }

                if (!pdfFile) {
                    driveError.textContent = "Isi link Google Drive atau unggah file PDF.";
                    driveError.classList.remove("hidden");
                    return false;
                }

                driveError.classList.add("hidden");
                return true;
            }

            function refreshSubmitState() {
                const ok = validateTitle() &&
                    validateImage(thumbnailInput.files[0]) &&
                    validateDriveOrPdf();
                toggleSubmitButton(ok);
            }

            fileNameInput.addEventListener("input", refreshSubmitState);
            driveLinkInput.addEventListener("input", refreshSubmitState);

            thumbnailInput.addEventListener("change", function() {
                const file = this.files[0];
                if (file && validateImage(file)) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        thumbnailPreview.src = event.target.result;
                        thumbnailPreview.classList.remove("hidden");
                    };
                    reader.readAsDataURL(file);
                } else {
                    thumbnailPreview.classList.add("hidden");
                    thumbnailPreview.src = "";
                }
                refreshSubmitState();
            });

            fileInput.addEventListener("change", function() {
                const file = this.files[0];
                if (file) {
                    fileNameDisplay.textContent = `File terpilih: ${file.name}`;
                    fileInfoContainer.classList.remove("hidden");
                } else {
                    fileInfoContainer.classList.add("hidden");
                }
                refreshSubmitState();
            });

            resetButton.addEventListener("click", function() {
                fileInput.value = "";
                fileNameDisplay.textContent = "File terpilih: Tidak ada file";
                fileInfoContainer.classList.add("hidden");
                refreshSubmitState();
            });

            form.addEventListener("submit", function(event) {
                if (!validateTitle() || !validateImage(thumbnailInput.files[0]) || !validateDriveOrPdf()) {
                    event.preventDefault();
                    alert("Pastikan judul, thumbnail, dan salah satu dari link Drive/PDF sudah diisi.");
                }
            });

            toggleSubmitButton(false);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
</body>

</html>
