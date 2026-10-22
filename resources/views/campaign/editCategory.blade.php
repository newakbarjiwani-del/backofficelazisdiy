<div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-20 flex items-center justify-center" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" @click="isOpen = false"></div>

    <!-- Modal content -->
    <div
        class="ml-56 mt-14 relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6 overflow-hidden transform transition-all">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 mb-3" id="modal-title">Edit Category Campaign
            </h3>
            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                &#10005;
            </button>
        </div>

        <!-- Formulir Campaign -->
        <form id="EditCategoryCampaign-form" action="{{ route('campaignCategory.update', $categories['id']) }}" method="POST"
            enctype="multipart/form-data" class="overflow-y-auto">
            @csrf
            @method('PUT')
            <div>
                <!-- Nama kategori Campaign -->
                <div>
                    <label for="campaign_category" class="block text-sm font-medium text-gray-700 mb-2">Nama
                        kategori campaign</label>
                    <input type="text" name="campaign_category" id="Editcampaign_category"
                        class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                        placeholder="Masukkan kategori campaign..." value="{{ $categories['campaign_category'] }}" required>
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
                <button type="submit"  id="submitButton"
                    class="inline-flex justify-center w-full rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>
