<!-- Modal -->
<div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-20 flex items-center justify-center" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" @click="isOpen = false"></div>

    <!-- Modal Content -->
    <div
        class="ml-56 mt-14 relative max-h-[calc(100vh-2rem)] bg-white rounded-lg shadow-xl w-full max-w-md p-6 overflow-hidden transform transition-all overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 mb-3" id="modal-title">Edit infak</h3>
            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                &#10005;
            </button>
        </div>

        <!-- Formulir -->
        <form id="editinfakForm" action="{{ route('infak.update', $infak['id']) }}" method="POST"
            enctype="multipart/form-data" class="overflow-y-auto">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div>
                <!-- Nama infak -->
                <div>
                    <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">Nama infak</label>
                    <input type="text" name="category_name" id="editcategory_name"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        placeholder="Masukkan nama infak..." value="{{ $infak['category_name'] }}" required>
                </div>

                <!-- Thumbnail -->
                <div class="mt-4">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        Thumbnail
                        <span class="italic text-xs">(Hanya file JPEG, JPG, atau PNG, max 2MB)</span>
                    </label>
                    <!-- Input File -->
                    <div>
                        <label id="labelnamefile"
                            class="block text-sm text-gray-500 italic">{{ basename($infak['thumbnail'] ?? 'Belum ada file') }}</label>
                        <input type="file" name="thumbnail" id="thumbnailedit"
                            class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                            accept="image/*">
                    </div>
                    <!-- Preview Thumbnail -->
                    <div id="previewContaineredit"
                        class="relative mt-3 w-40 h-auto rounded-lg border border-gray-300 {{ empty($infak['thumbnail']) ? 'hidden' : '' }}">
                        <img id="thumbnailPreviewedit" src="{{ $infak['thumbnail'] ?? '' }}" alt="Preview Thumbnail"
                            class="w-full h-auto">
                        <button id="resetButtonedit" type="button"
                            class="absolute top-1 right-1 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                    <p id="thumbnail-erroredit" class="hidden text-sm text-red-500 mt-1"></p>
                </div>
            </div>

            <!-- Tombol Batal dan Simpan -->
            <div class="flex flex-col mt-6 space-y-3 mb-5">
                <button type="button" @click="isOpen = false"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" id="submitButtonedit"
                    class="inline-flex justify-center w-full rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-green-700 disabled:opacity-50">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const thumbnailInput = document.getElementById('thumbnailedit');
    const thumbnailPreview = document.getElementById('thumbnailPreviewedit');
    const previewContainer = document.getElementById('previewContaineredit');
    const errorElement = document.getElementById('thumbnail-erroredit');
    const submitButton = document.getElementById('submitButtonedit');
    const resetButton = document.getElementById('resetButtonedit');
    const labelname = document.getElementById('labelnamefile');

    function validateFile(file) {
        if (!file) return true; // Jika tidak ada file baru, tetap valid

        if (file.size > 2 * 1024 * 1024) {
            // Ukuran file lebih dari 2MB
            errorElement.textContent = "Ukuran file terlalu besar (maksimal 2MB).";
            errorElement.classList.remove('hidden');
            submitButton.disabled = true;
            return false;
        }
        errorElement.classList.add('hidden');
        submitButton.disabled = false;
        return true;
    }

    thumbnailInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (validateFile(file)) {
            if (file) {
                // Preview gambar baru
                const reader = new FileReader();
                reader.onload = function(event) {
                    thumbnailPreview.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                    labelname.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        } else {
            thumbnailPreview.src = "{{ $infak['thumbnail'] ?? '' }}"; // Reset ke gambar lama
            previewContainer.classList.add('hidden');
        }
    });

    resetButton.addEventListener('click', function() {
        thumbnailInput.value = '';
        thumbnailPreview.src = "{{ $infak['thumbnail'] ?? '' }}";
        previewContainer.classList.remove('hidden');
        submitButton.disabled = false; // Aktifkan tombol submit
    });

    // Aktifkan tombol submit jika gambar lama digunakan
    if (!thumbnailInput.value) submitButton.disabled = false;
    // document.getElementById('thumbnailedit').addEventListener('change', function() {
    //     if (this.files && this.files[0]) {
    //         console.log('File selected:', this.files[0].name); // Logs the selected file name for debugging
    //     }
    // });
</script>
