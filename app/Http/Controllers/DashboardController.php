<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */



    // public function index(Request $request)
    // {
    //     // Ambil base URL dari .env
    //     $baseUrl = env('API_BASE_URL');

    //     // Ambil nilai filter dari request
    //     $start_date = $request->query('start_date');
    //     $end_date = $request->query('end_date');

    //     // Validasi tanggal agar tidak error jika kosong atau tidak sesuai format
    //     $request->validate([
    //         'start_date' => 'nullable|date',
    //         'end_date'   => 'nullable|date|after_or_equal:start_date',
    //     ]);

    //     // Buat URL dengan query parameter jika filter diterapkan
    //     $queryParams = array_filter([
    //         'start_date' => $start_date,
    //         'end_date'   => $end_date,
    //     ]);

    //     $summaryFilterUrl = $baseUrl . '/summary' . (count($queryParams) ? '?' . http_build_query($queryParams) : '');

    //     // Panggil API dan konversi hasil ke array
    //     $summaryResponse = Http::get($summaryFilterUrl)->json();

    //     // Pastikan response memiliki data yang sesuai
    //     $data = [
    //         'totalTransaction' => $summaryResponse['total_transaction'],
    //         'countTransaction' => $summaryResponse['total_transaction_count'],
    //         'countBilling' => $summaryResponse['total_billing_count'],
    //         'totalDonatur' => $summaryResponse['total_donatur'],
    //         'totalMigration' => $summaryResponse['total_migration'],
    //         'totalQris' => $summaryResponse['total_qris'],
    //         'totalForIct' => $summaryResponse['total_for_ict'],
    //     ];
    //     return view('admin.main', $data);
    // }

    public function index(Request $request)
    {
        // Ambil base URL dari .env
        $baseUrl = env('API_BASE_URL');

        // Ambil token dari session
        $token = $request->session()->get('token');

        // Ambil nilai filter dari request
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        // Validasi tanggal agar tidak error jika kosong atau tidak sesuai format
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        // Buat URL dengan query parameter jika filter diterapkan
        $queryParams = array_filter([
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        $summaryFilterUrl = $baseUrl . '/summary' . (count($queryParams) ? '?' . http_build_query($queryParams) : '');

        // Panggil API dengan token di header
        $summaryResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($summaryFilterUrl)->json();

        // Pastikan response memiliki data yang sesuai
        $data = [
            'totalTransaction' => $summaryResponse['total_transaction'],
            'countTransaction' => $summaryResponse['total_transaction_count'],
            'countBilling' => $summaryResponse['total_billing_count'],
            'totalDonatur' => $summaryResponse['total_donatur'],
            'totalMigration' => $summaryResponse['total_migration'],
            'totalQris' => $summaryResponse['total_qris'],
            'totalForIct' => $summaryResponse['total_for_ict'],
        ];

        // Tampilkan data di view
        return view('admin.main', $data);
    }


    // public function getAllTransactions()
    // {
    //      // Ambil base URL dari .env
    //     $baseUrl = env('API_BASE_URL');
    //     $apiUrl = "{$baseUrl}/transactions";

    //     $chartData = [];
    //     $categories = ['zakat', 'campaign', 'infak']; // Kategori yang ingin dipisahkan
    //     $currentPage = 1;

    //     do {
    //         // Ambil data per halaman
    //         $response = Http::get($apiUrl, ['page' => $currentPage]);

    //         if (!$response->successful()) {
    //             return response()->json(['error' => 'Gagal mengambil data'], 500);
    //         }

    //         $data = $response->json();
    //         $transactions = $data['data']; // Sesuaikan dengan struktur API

    //         // Proses transaksi dan kelompokkan berdasarkan kategori
    //         foreach ($transactions as $transaction) {
    //             $date = $this->safeGet($transaction, 'transaction_date');
    //             $amount = $this->safeGet($transaction, 'transaction_amount', 0); // Default 0 jika tidak ada amount

    //             // Tentukan kategori transaksi
    //             $category = 'lainnya'; // Default jika bukan zakat, campaign, atau infak
    //             if (!empty($transaction['zakat_id'])) {
    //                 $category = 'zakat';
    //             } elseif (!empty($transaction['campaign_id'])) {
    //                 $category = 'campaign';
    //             } elseif (!empty($transaction['infak_id'])) {
    //                 $category = 'infak';
    //             }

    //             // Inisialisasi jika belum ada
    //             if (!isset($chartData[$category])) {
    //                 $chartData[$category] = [];
    //             }
    //             if (!isset($chartData[$category][$date])) {
    //                 $chartData[$category][$date] = 0;
    //             }

    //             // Tambahkan jumlah transaksi ke kategori yang sesuai
    //             $chartData[$category][$date] += $amount;
    //         }

    //         // Cek apakah masih ada halaman berikutnya
    //         $currentPage++;
    //         $totalPages = $data['total_pages'] ?? 1;
    //     } while ($currentPage <= $totalPages);

    //     // Buat format data untuk Chart.js
    //     $datasets = [];
    //     $allDates = [];

    //     foreach ($categories as $category) {
    //         if (!isset($chartData[$category])) {
    //             continue;
    //         }

    //         $allDates = array_merge($allDates, array_keys($chartData[$category]));
    //     }

    //     $allDates = array_unique($allDates);
    //     sort($allDates); // Urutkan tanggal

    //     // Warna berbeda untuk tiap kategori
    //     $colors = [
    //         'zakat' => ['border' => 'rgba(255, 99, 132, 1)', 'background' => 'rgba(255, 99, 132, 0.2)'],
    //         'campaign' => ['border' => 'rgba(54, 162, 235, 1)', 'background' => 'rgba(54, 162, 235, 0.2)'],
    //         'infak' => ['border' => 'rgba(255, 206, 86, 1)', 'background' => 'rgba(255, 206, 86, 0.2)']
    //     ];

    //     foreach ($categories as $category) {
    //         $dataPoints = [];
    //         foreach ($allDates as $date) {
    //             $dataPoints[] = $chartData[$category][$date] ?? 0; // Jika tidak ada, beri 0
    //         }

    //         $datasets[] = [
    //             'label' => ucfirst($category), // Nama kategori
    //             'data' => $dataPoints,
    //             'borderColor' => $colors[$category]['border'],
    //             'backgroundColor' => $colors[$category]['background'],
    //             'borderWidth' => 2,
    //             'fill' => true
    //         ];
    //     }

    //     // Kirim data dalam format JSON yang diterima Chart.js
    //     return response()->json([
    //         'labels' => $allDates,
    //         'datasets' => $datasets
    //     ]);
    // }
    // public function getCampaigns()
    // {
    //     $baseUrl = env('API_BASE_URL');
    //     $url = "{$baseUrl}/campaigns"; // URL API yang mengembalikan data kampanye

    //     $campaigns = $this->fetchAllCampaigns($url); // Panggil fungsi untuk mengambil semua data

    //     if (empty($campaigns)) {
    //         return response()->json(['error' => 'Gagal mengambil data dari API.'], 500);
    //     }

    //     // Filter hanya campaign dengan current_amount > 0
    //     $filteredCampaigns = collect($campaigns)
    //         ->filter(fn($campaign) => $this->safeGet($campaign, 'current_amount') > 0)
    //         ->values();

    //     // Sorting berdasarkan current_amount tertinggi
    //     $sortedCampaigns = $filteredCampaigns
    //         ->sortByDesc('current_amount')
    //         ->slice(0, 5) // Batasi ke 5 campaign dengan current amount tertinggi
    //         ->toArray();

    //     // Struktur data untuk ChartJS
    //     $chartData = [
    //         'labels' => [],
    //         'target_amounts' => [],
    //         'current_amounts' => [],
    //     ];

    //     foreach ($sortedCampaigns as $campaign) {
    //         $chartData['labels'][] = strlen($campaign['campaign_name']) > 20
    //             ? substr($campaign['campaign_name'], 0, 20) . "..."
    //             : $campaign['campaign_name'];
    //         $chartData['target_amounts'][] = $this->safeGet($campaign, 'target_amount');
    //         $chartData['current_amounts'][] = $this->safeGet($campaign, 'current_amount');
    //     }

    //     return response()->json($chartData);
    // }

    // // Fungsi untuk mengambil nilai dengan pengamanan terhadap null atau undefined
    // private function safeGet($data, $key)
    // {
    //     return isset($data[$key]) && $data[$key] !== null ? $data[$key] : 0;
    // }

    // // Fungsi untuk mengambil seluruh data dengan pagination
    // private function fetchAllCampaigns($url, $campaigns = [])
    // {
    //     // Ambil data dari URL API
    //     $response = Http::get($url);

    //     if ($response->successful()) {
    //         $result = $response->json();

    //         // Gabungkan data campaign yang didapatkan
    //         $campaigns = array_merge($campaigns, $result['data']);

    //         // Jika ada link untuk halaman berikutnya, ambil data dari halaman berikutnya
    //         if (isset($result['next_page_url']) && $result['next_page_url']) {
    //             return $this->fetchAllCampaigns($result['next_page_url'], $campaigns);
    //         }
    //     }

    //     return $campaigns; // Kembalikan data yang sudah digabungkan
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // public function fetchTransactions()
    // {
    //     $baseUrl = env('API_BASE_URL');
    //     $apiUrl = "{$baseUrl}/transactions";

    //     // Inisialisasi variabel SEBELUM perulangan
    //     $labels = [];
    //     $campaignData = [];
    //     $zakatData = [];
    //     $infakData = [];
    //     $transactions = [];

    //     try {
    //         $response = Http::get($apiUrl);

    //         if ($response->failed()) {
    //             return response()->json(['error' => 'Failed to fetch data'], 500);
    //         }

    //         $data = $response->json();

    //         // Debug: Cek apakah data ada
    //         if (empty($data['data'])) {
    //             // Kirim array kosong jika tidak ada data
    //             return view('admin.main', [
    //                 'transactions' => [],
    //                 'labels' => [],
    //                 'campaignData' => [],
    //                 'zakatData' => [],
    //                 'infakData' => []
    //             ]);
    //         }

    //         // Proses data transaksi
    //         foreach ($data['data'] as $transaction) {
    //             $transactionDate = $transaction['transaction_date'];

    //             // Tambahkan tanggal ke labels
    //             if (!in_array($transactionDate, $labels)) {
    //                 $labels[] = $transactionDate;
    //             }

    //             // Proses Campaign
    //             if (!empty($transaction['transaction_amount']) && !is_null($transaction['campaign'])) {
    //                 $campaignData[] = $transaction['transaction_amount'];
    //                 $transactions[] = [
    //                     'type' => 'campaign',
    //                     'amount' => $transaction['transaction_amount'],
    //                     'date' => $transactionDate
    //                 ];
    //             } else {
    //                 $campaignData[] = 0;
    //             }

    //             // Proses Zakat
    //             if (!empty($transaction['transaction_amount']) && !is_null($transaction['zakat'])) {
    //                 $zakatData[] = $transaction['transaction_amount'];
    //                 $transactions[] = [
    //                     'type' => 'zakat',
    //                     'amount' => $transaction['transaction_amount'],
    //                     'date' => $transactionDate
    //                 ];
    //             } else {
    //                 $zakatData[] = 0;
    //             }

    //             // Proses Infak
    //             if (!empty($transaction['transaction_amount']) && !is_null($transaction['infak'])) {
    //                 $infakData[] = $transaction['transaction_amount'];
    //                 $transactions[] = [
    //                     'type' => 'infak',
    //                     'amount' => $transaction['transaction_amount'],
    //                     'date' => $transactionDate
    //                 ];
    //             } else {
    //                 $infakData[] = 0;
    //             }
    //         }

    //         // Kirim data ke view
    //         return view('admin.main', compact('transactions', 'labels', 'campaignData', 'zakatData', 'infakData'));

    //     } catch (\Exception $e) {
    //         // Tangani error
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


}
