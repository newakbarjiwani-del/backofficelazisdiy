<!-- Modal -->
<div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-20 flex items-center justify-center" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" @click="isOpen = false"></div>

    <div
        class="ml-56 mt-14 relative max-h-[calc(100vh-2rem)] bg-white rounded-lg shadow-xl w-full max-w-md p-6 overflow-hidden transform transition-all overflow-y-auto">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 mb-3" id="modal-title">Unggah Laporan</h3>
            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                &#10005;
            </button>
        </div>

        <form id="reportsform" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data"
            class="overflow-y-auto">
            @csrf
            <div>
                <div>
                    <label for="file_name" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="title" id="file_name"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        placeholder="Contoh: Untuk Tahun yang Berakhir Tanggal 31 Desember 2024..." required>
                    <p id="errorMessage" class="text-red-500 text-sm mt-1 hidden">Judul tidak boleh kosong.</p>
                </div>

                <div class="mt-4">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        Thumbnail
                        <span class="italic text-xs">(JPG/PNG max 2MB)</span>
                    </label>
                    <input type="file" name="thumbnail" id="thumbnail"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/png,image/jpeg,image/webp" required>
                    <img id="thumbnailPreview" src="" alt="Preview thumbnail"
                        class="hidden mt-3 w-full h-40 object-cover rounded-md border border-gray-200">
                    <p id="thumbnail-error" class="hidden text-sm text-red-500 mt-1"></p>
                </div>

                <div class="mt-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        File PDF
                        <span class="italic text-xs">(max 10MB)</span>
                    </label>
                    <input type="file" name="file" id="file"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept=".pdf" required>

                    <div id="fileInfo" class="hidden mt-3 flex items-center text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.172 11l-3.172 3.172a4 4 0 11-5.656-5.656l3.172 3.172a2 2 0 102.828-2.828l-3.172-3.172a4 4 0 115.656 5.656L14.172 11z" />
                        </svg>
                        <p id="fileName" class="text-sm truncate max-w-xs">File terpilih: Tidak ada file</p>
                        <button id="resetButton" type="button"
                            class="ml-3 text-white bg-red-500 rounded px-2 py-1 text-sm hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                    <p id="file-error" class="hidden text-sm text-red-500 mt-1"></p>
                </div>
            </div>

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
