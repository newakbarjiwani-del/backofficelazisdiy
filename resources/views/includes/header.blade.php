<header class="flex justify-between ml-56 w-[calc(100%-14rem)] fixed top-0 left-0 bg-white shadow-md p-4 z-50">
    <div id="time-display"></div>
    <div class="flex items-center">
      

        <img src="{{ asset('assets/img/messages-3.jpg') }}" alt="" class="rounded-full w-8 h-8 mr-2">

        <span class="mx-2">{{ session('user')['name'] }}</span>
    </div>
</header>

<script>
    // Ambil waktu dari server
    let serverTime = new Date("{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}");

    function updateClock() {
        // Tambahkan satu detik ke waktu server
        serverTime.setSeconds(serverTime.getSeconds() + 1);

        // Format waktu
        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        // Tampilkan waktu di elemen HTML
        document.getElementById('time-display').innerText = serverTime.toLocaleString('id-ID', options);
    }

    // Jalankan pembaruan waktu setiap detik
    setInterval(updateClock, 1000);
    updateClock(); // Panggil langsung untuk menampilkan waktu awal
</script>
