 <!-- Modal -->
 <div x-cloak x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-20 flex items-center justify-center" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">

     <!-- Backdrop -->
     <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" @click="isOpen = false"></div>

     <!-- Modal content -->
     <div
         class="ml-56 mt-14 relative max-h-[calc(100vh-2rem)] bg-white rounded-lg shadow-xl w-full max-w-md p-6 overflow-hidden transform transition-all overflow-y-auto">
         <!-- Header -->
         <div class="flex items-center justify-between">
             <h3 class="text-lg font-medium text-gray-900 mb-3" id="modal-title">Unggah Laporan
             </h3>
             <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                 <span class="sr-only">Close</span>
                 &#10005;
             </button>
         </div>

         <!-- Formulir Campaign -->
         <form id="reportsform" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data"
             class="overflow-y-auto">
             @csrf
             <div>
                 <!-- Nama kategori Campaign -->
                 <div>
                     <label for="file_name" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                     <input type="text" name="title" id="file_name"
                         class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                         placeholder="Masukkan title..." required>
                     <p id="errorMessage" class="text-red-500 text-sm mt-1 hidden">
                         nama file ini sudah ada.</p>
                 </div>
                 <div class="mt-4">
                     <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                         File
                         <span class="italic text-xs">( Hanya file PDF
                             max 2MB )</span>
                     </label>
                     <input type="file" name="file" id="file"
                         class="mt-1 block w-full py-1.5 px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border"
                         accept=".pdf" required>

                     <div id="fileInfo" class="hidden mt-3 flex items-center text-gray-700">
                         <!-- Ikon PDF -->
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M14.172 11l-3.172 3.172a4 4 0 11-5.656-5.656l3.172 3.172a2 2 0 102.828-2.828l-3.172-3.172a4 4 0 115.656 5.656L14.172 11z" />
                         </svg>
                         <p id="fileName" class="text-sm truncate max-w-xs">File terpilih: Tidak ada file</p>

                         <!-- Tombol Reset -->
                         <button id="resetButton" type="button"
                             class="ml-3 text-white bg-red-500 rounded px-2 py-1 text-sm hover:bg-red-600">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="size-6">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                             </svg>

                         </button>
                     </div>

                     <p id="file-error" class="hidden text-sm text-red-500 mt-1"></p>


                     <p id="file-error" class="hidden text-sm text-red-500 mt-1">Ukuran file tidak
                         boleh lebih dari 2MB!</p>
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
