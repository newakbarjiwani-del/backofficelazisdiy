<aside class="bg-white border border-r w-56 h-screen flex flex-col shadow-md">
    <!-- Header -->
    <div class="flex items-center justify-center my-3">
        <a href="{{ route('dashboard.index') }}" class="flex items-center">
            <img src="{{ asset('assets/img/lazismu-logo.png') }}" alt="" class="w-8">
            <span class="ml-2 font-bold text-xl">Lazismu</span>
        </a>
    </div>
    <div class="border border-gray-200 mt-2"></div>

    <!-- Navigasi Utama -->
    <div class="flex-1 overflow-y-auto overflow-hidden mt-2">
        <ul class="w-full flex flex-col items-center">
            <!-- Dashboard -->
            <a href="{{ route('dashboard.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('dashboard.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/dashboard.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Dashboard</li>
            </a>

            <!-- Pengguna -->
            <a href="{{ route('pengguna.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2  {{ Request::routeIs('pengguna.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/user.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Pengguna</li>
            </a>

            <!-- Campaign Dropdown -->
            <div class="w-full" id="campaignDropdown">
                <button id="dropdownToggle"
                    class="w-full flex justify-between items-center px-8 py-2 rounded-md transition duration-300 transform hover:scale-105 {{ Request::routeIs('campaign.index', 'campaignCategory.index', 'priority.index', 'recomendation.index', 'aktif.index', 'nonaktif.index') ? 'open' : '' }}">
                    <span class="font-semibold">Campaign</span>
                    <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 transform transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <div id="dropdownMenu" class="w-full transition-all duration-300 overflow-hidden mb-4">
                    <a href="{{ route('campaign.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaign.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/campaign.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign</span>
                    </a>
                    <a href="{{ route('campaignCategory.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaignCategory.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/list.svg') }}" alt="" class="w-5 mr-2">
                        <span>Category</span>
                    </a>
                    <a href="{{ route('priority.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('priority.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/priority.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign priority</span>
                    </a>
                    <a href="{{ route('recomendation.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('recomendation.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/lightning.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign rekomendasi</span>
                    </a>
                    <a href="{{ route('aktif.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2{{ Request::routeIs('aktif.index') ? 'font-semibold bg-orange-200' : '' }}">
                        <img src="{{ asset('assets/img/active.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign aktif</span>
                    </a>
                    <a href="{{ route('nonaktif.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 {{ Request::routeIs('nonaktif.index') ? 'font-semibold bg-orange-200' : '' }}">
                        <img src="{{ asset('assets/img/nonactive.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign nonaktif</span>
                    </a>
                </div>
            </div>

            {{-- Ziswaf dropdown --}}
            <div class="w-full mt-2" id="ziswafDropdown">
                <button id="dropdownToggleZiswaf"
                    class="w-full flex justify-between items-center px-8 py-2 rounded-md transition duration-300 transform hover:scale-105 {{ Request::routeIs('zakat.index', 'infak.index') ? 'open' : '' }}">
                    <span class="font-semibold">Ziswaf</span>
                    <svg id="arrowIconZiswaf" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 transform transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <div id="dropdownMenuZiswaf" class="w-full transition-all duration-300 overflow-hidden mb-4">
                    <a href="{{ route('zakat.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('zakat.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/zakat.svg') }}" alt="" class="w-5 mr-2">
                        <span>Zakat</span>
                    </a>
                    <a href="{{ route('infak.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('infak.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/infaq.svg') }}" alt="" class="w-5 mr-2">
                        <span>Infak</span>
                    </a>
                </div>
            </div>

            <!-- Transaksi -->
            <a href="{{ route('tagihan.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('tagihan.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/credit.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Tagihan</li>
            </a>

            <!-- Transaksi -->
            <a href="{{ route('transaksi.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('transaksi.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/cash.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Donasi</li>
            </a>

            <div class="w-full mt-2" id="newsDropdown">
                <button id="dropdownTogglenews"
                    class="w-full flex justify-between items-center px-8 py-2 rounded-md transition duration-300 transform hover:scale-105 {{ Request::routeIs('news.index', 'newscampaign.index') ? 'open' : '' }}">
                    <span class="font-semibold">Kabar terbaru</span>
                    <svg id="arrowIconnews" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 transform transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <div id="dropdownMenunews" class="w-full transition-all duration-300 overflow-hidden mb-4">
                    <a href="{{ route('news.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('news.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/kabarterbaru.svg') }}" alt="" class="w-5 mr-2">
                        <span>List kabar terbaru</span>
                    </a>
                    <a href="{{ route('newscampaign.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('newscampaign.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/listnews.svg') }}" alt="" class="w-5 mr-2">
                        <span>Kabar terbaru</span>
                    </a>
                </div>
            </div>
            <a href="{{ route('reports.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('reports.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/document.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Laporan</li>
            </a>
        </ul>
    </div>

    <!-- Footer -->
    <form method="POST" action="{{ route('logout') }}" class="w-full">
        @csrf
        <button type="submit"
            class="w-full flex items-center px-8 py-2 hover:bg-orange-200 hover:overflow-hidden rounded-md transition duration-300 transform hover:scale-105 mb-4">
            <img src="{{ asset('assets/img/logout.svg') }}" alt="" class="w-7 mr-2">
            <span class="font-semibold">Logout</span>
        </button>
    </form>
</aside>

<script>
    const dropdownToggle = document.getElementById('dropdownToggle');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const arrowIcon = document.getElementById('arrowIcon');

    // Status default dropdown
    let isOpen = false;
    dropdownMenu.style.maxHeight = '0'; // Dropdown tertutup di awal

    // Fungsi untuk toggle dropdown
    dropdownToggle.addEventListener('click', () => {
        // Toggle status dropdown
        isOpen = !isOpen;

        if (isOpen) {
            // Jika terbuka
            dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px'; // Buka dropdown
            arrowIcon.classList.remove('rotate-180'); // Putar ikon
        } else {
            // Jika tertutup
            dropdownMenu.style.maxHeight = '0'; // Tutup dropdown
            arrowIcon.classList.add('rotate-180'); // Kembalikan ikon
        }
    });

    if (dropdownToggle.classList.contains('open')) {
        dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';
        arrowIcon.classList.remove('rotate-180');
        isOpen = true; // Set status dropdown terbuka
    }

    const dropdownToggleZiswaf = document.getElementById('dropdownToggleZiswaf');
    const dropdownMenuZiswaf = document.getElementById('dropdownMenuZiswaf');
    const arrowIconZiswaf = document.getElementById('arrowIconZiswaf');

    // Status default dropdown
    let isOpenZiswaf = false;
    dropdownMenuZiswaf.style.maxHeight = '0'; // Dropdown tertutup di awal

    // Fungsi untuk toggle dropdown
    dropdownToggleZiswaf.addEventListener('click', () => {
        // Toggle status dropdown
        isOpenZiswaf = !isOpenZiswaf;

        if (isOpenZiswaf) {
            // Jika terbuka
            dropdownMenuZiswaf.style.maxHeight = dropdownMenuZiswaf.scrollHeight + 'px'; // Buka dropdown
            arrowIconZiswaf.classList.remove('rotate-180'); // Putar ikon
        } else {
            // Jika tertutup
            dropdownMenuZiswaf.style.maxHeight = '0'; // Tutup dropdown
            arrowIconZiswaf.classList.add('rotate-180'); // Kembalikan ikon
        }
    });

    if (dropdownToggleZiswaf.classList.contains('open')) {
        dropdownMenuZiswaf.style.maxHeight = dropdownMenuZiswaf.scrollHeight + 'px';
        arrowIconZiswaf.classList.remove('rotate-180');
        isOpenZiswaf = true; // Set status dropdown terbuka
    }

    // const dropdownToggleZiswaf = document.getElementById('dropdownToggleZiswaf');
    // const dropdownMenuZiswaf = document.getElementById('dropdownMenuZiswaf');
    // const arrowIconZiswaf = document.getElementById('arrowIconZiswaf');

    // // Status default dropdown
    // let ZiswafisOpen = false;
    // dropdownMenuZiswaf.style.maxHeight = '0'; // Default tertutup

    // // Fungsi untuk toggle dropdown
    // dropdownToggleZiswaf.addEventListener('click', () => {
    //     ZiswafisOpen = !ZiswafisOpen;

    //     if (ZiswafisOpen) {
    //         // Buka dropdown
    //         dropdownMenuZiswaf.style.maxHeight = dropdownMenuZiswaf.scrollHeight + 'px'; // Sesuai isi konten
    //         arrowIconZiswaf.classList.add('rotate-180'); // Tambahkan rotasi
    //     } else {
    //         // Tutup dropdown
    //         dropdownMenuZiswaf.style.maxHeight = '0'; // Tutup dropdown
    //         arrowIconZiswaf.classList.remove('rotate-180'); // Hilangkan rotasi
    //     }
    // });
    // if (dropdownToggleZiswaf.classList.contains('open')) {
    //     dropdownMenuZiswaf.style.maxHeight = dropdownMenu.scrollHeight + 'px';
    //     arrowIconZiswaf.classList.remove('rotate-180');
    //     ZiswafisOpen = true; // Set status dropdown terbuka
    // }

    const dropdownTogglenews = document.getElementById('dropdownTogglenews');
    const dropdownMenunews = document.getElementById('dropdownMenunews');
    const arrowIconnews = document.getElementById('arrowIconnews');

    // Status default dropdown
    let isOpennews = false;
    dropdownMenunews.style.maxHeight = '0'; // Dropdown tertutup di awal

    // Fungsi untuk toggle dropdown
    dropdownTogglenews.addEventListener('click', () => {
        // Toggle status dropdown
        isOpennews = !isOpennews;

        if (isOpennews) {
            // Jika terbuka
            dropdownMenunews.style.maxHeight = dropdownMenunews.scrollHeight + 'px'; // Buka dropdown
            arrowIconnews.classList.remove('rotate-180'); // Putar ikon
        } else {
            // Jika tertutup
            dropdownMenunews.style.maxHeight = '0'; // Tutup dropdown
            arrowIconnews.classList.add('rotate-180'); // Kembalikan ikon
        }
    });

    if (dropdownTogglenews.classList.contains('open')) {
        dropdownMenunews.style.maxHeight = dropdownMenunews.scrollHeight + 'px';
        arrowIconnews.classList.remove('rotate-180');
        isOpennews = true; // Set status dropdown terbuka
    }
</script>
