<div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-20 flex items-center justify-center" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" @click="isOpen = false"></div>

    <!-- Modal content -->
    <div
        class="ml-56 mt-14 relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-6 overflow-hidden transform transition-all">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg text-gray-900 mb-3 font-bold" id="modal-title">Buat
                Kabar Terbaru
            </h3>
            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                &#10005;
            </button>
        </div>

        <!-- Formulir Campaign -->
        <form id="kabarterbaru-form-{{ $campaign['id'] }}"
            action="{{ route('newsCampaign.setNews', ['id' => $campaign['id']]) }}" method="POST"
            enctype="multipart/form-data" class="h-96 overflow-y-auto">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div>
                    <label for="latest_news_date" class="block text-left text-sm font-medium text-gray-700 mb-2">Tanggal
                        :</label>
                    <input type="date" name="latest_news_date" id="latest_news_date"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        required>
                </div>




                {{-- <div>
                    <label for="image-{{ $campaign['id'] }}" class="block text-left text-sm font-medium text-gray-700 mb-2">
                        Gambar
                        <span class="italic text-xs">( Hanya file JPEG, JPG, atau PNG,
                            max 2MB )</span>
                    </label>
                    <input type="file" name="image" id="image-{{ $campaign['id'] }}"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/*" required>
                    <p id="image-error" class="hidden text-sm text-red-500 mt-1">Ukuran file tidak
                        boleh lebih dari 2MB!</p>
                </div> --}}


                <div>
                    <label for="image_{{ $campaign['id'] }}" class="block text-sm text-left font-medium text-gray-700 mb-2">
                        Image
                        <span class="italic text-xs">(Hanya file JPEG, JPG, atau PNG, max 2MB)</span>
                    </label>
                    <input type="file" name="image" id="image_{{ $campaign['id'] }}"
                        data-id="{{ $campaign['id'] }}"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        accept="image/*">

                    <!-- Preview Thumbnail -->
                    <div id="previewContainer_{{ $campaign['id'] }}"
                        class="relative mt-3 w-40 h-auto rounded-lg border border-gray-300 {{ empty($campaign['image']) ? 'hidden' : '' }}">
                        <img id="thumbnailPreview_{{ $campaign['id'] }}" src="{{ $campaign['image'] ?? '' }}"
                            alt="Preview Thumbnail" class="w-full h-auto">
                        <button id="resetButton_{{ $campaign['id'] }}" type="button"
                            class="absolute top-1 right-1 text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                    <p id="imageerror_{{ $campaign['id'] }}" class="hidden text-sm text-left text-red-500 mt-1">
                        Ukuran file tidak boleh lebih dari 2MB!
                    </p>
                </div>

                <div class="col-span-2">
                    <label for="description" class="block text-left text-sm font-medium text-gray-700 mb-2">Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border px-2"
                        placeholder="Masukkan deskripsi" required></textarea>
                </div>

            </div>

            <!-- Tombol Batal dan Simpan -->
            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" @click="isOpen = false"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: 'textarea#description',  // Ganti dengan ID yang sesuai jika perlu
        menubar: false, // Nonaktifkan menubar, jika Anda ingin menonaktifkannya
        plugins: 'advlist autolink lists charmap print preview anchor help',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        height: 300,  // Sesuaikan tinggi editor sesuai kebutuhan
        branding: false,
    });
</script>

<script>
    document.addEventListener('change', function(event) {
        // Deteksi input file yang berubah
        if (event.target && event.target.matches('input[type="file"][id^="image_"]')) {
            const thumbnailInput = event.target;
            const campaignId = thumbnailInput.dataset.id; // Ambil ID dari data-id
            const previewContainer = document.getElementById(`previewContainer_${campaignId}`);
            const thumbnailPreview = document.getElementById(`thumbnailPreview_${campaignId}`);
            const errorMessage = document.getElementById(`imageerror_${campaignId}`);

            const file = thumbnailInput.files[0];

            if (file) {
                // Validasi ukuran file (maksimum 2MB)
                if (file.size >= 2 * 1024 * 1024) {
                    errorMessage.textContent =
                        "Ukuran file tidak boleh lebih dari 2MB!"; // Tampilkan pesan error
                    errorMessage.classList.remove('hidden');
                    thumbnailInput.value = ''; // Reset input file
                    previewContainer.classList.add('hidden');
                } else {
                    errorMessage.classList.add('hidden'); // Sembunyikan pesan error
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnailPreview.src = e.target.result; // Tampilkan preview gambar baru
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    })
    document.addEventListener('click', function(event) {
        if (event.target && event.target.id.startsWith('resetButton_')) {
            const campaignId = event.target.id.split('_')[1]; // Ambil ID campaign
            const fileInput = document.getElementById(`image_${campaignId}`);
            const previewContainer = document.getElementById(`previewContainer_${campaignId}`);
            const imagePreview = document.getElementById(`thumbnailPreview_${campaignId}`);

            // Reset input file dan preview
            if (fileInput) {
                fileInput.value = ''; // Reset nilai input file
            }
            if (imagePreview) {
                imagePreview.src = ''; // Kosongkan src gambar
            }
            if (previewContainer) {
                previewContainer.classList.add('hidden'); // Sembunyikan preview container
            }
        }
    });
</script>
