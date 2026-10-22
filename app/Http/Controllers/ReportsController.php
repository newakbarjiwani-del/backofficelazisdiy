<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $baseUrl = env('API_BASE_URL');  // Base URL API (misalnya untuk mengambil laporan)
        $reportsUrl = env('REPORTS_URL'); // URL untuk akses file PDF (misalnya untuk akses storage)
    
        $reportUrl = "{$baseUrl}/get-report";
    
        $month = $request->get('month', '');
        $year = $request->get('year', '');
    
        // Tambahkan parameter month jika ada
        if (!empty($month)) {
            $reportUrl .= "?month={$month}";
        }
    
       // Jika parameter year ada dan month sudah ada di URL, gunakan "&" untuk menggabungkannya
        if (!empty($year)) {
            $reportUrl .= empty($month) ? "?year={$year}" : "&year={$year}";
        }
    
        $reportsResponse = Http::get($reportUrl)->json();
    
        // Mengubah path file menjadi URL lengkap dengan REPORTS_URL
        foreach ($reportsResponse as &$report) {
            // Gantikan 'file_path' dengan URL lengkap untuk file yang disimpan di storage
            $report['file_url'] = "{$reportsUrl}/storage/{$report['file_path']}";
            $report['created_at'] = Carbon::parse($report['created_at'])->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
        }
    
        $data = [
            'reports' => $reportsResponse,
        ];
    
        return view('Reports.index', $data);
    }
    
    // public function index(Request $request)
    // {
    //     $baseUrl = env('API_BASE_URL');  // Base URL API (misalnya untuk mengambil laporan)
    //     $reportsUrl = env('REPORTS_URL'); // URL untuk akses file PDF (misalnya untuk akses storage)
    
    //     $reportUrl = "{$baseUrl}/get-report";  // URL untuk API laporan
    
    //     $month = $request->get('month', '');  // Mendapatkan bulan dari request
    //     $year = $request->get('year', '');    // Mendapatkan tahun dari request
    
    //     // Menambahkan parameter month dan year jika ada
    //     if (!empty($month)) {
    //         $reportUrl .= "?month={$month}";
    //     }
    
    //     if (!empty($year)) {
    //         $reportUrl .= empty($month) ? "?year={$year}" : "&year={$year}";
    //     }
    
    //     // Mengambil data laporan dari API
    //     $reportsResponse = Http::get($reportUrl)->json();
    
    //     // Mengubah path file menjadi URL lengkap dengan REPORTS_URL
    //     foreach ($reportsResponse as &$report) {
    //         // Gantikan 'file_path' dengan URL lengkap untuk file yang disimpan di storage
    //         $report['file_url'] = "{$reportsUrl}/storage/{$report['file_path']}";

    //                 // Format tanggal 'created_at' menjadi 'Y-m-d H:i:s'
    //         // 
    //     }
    
      
    
    //     // Menyiapkan data yang akan dikirimkan ke view
    //     $data = [
    //         'reports' => $reportsResponse,
    //     ];
    
    //     return view('Reports.index', $data);  // Mengirim data ke view
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
        try {
            $baseUrl = env('API_BASE_URL');
            $uploadfilereport = "{$baseUrl}/upload-report";
    
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf|max:2048', // Hanya file PDF dengan ukuran maksimal 2MB
            ]);
    
            // Siapkan permintaan HTTP menggunakan asMultipart
            $requestHttp = Http::asMultipart();
    
            // Pastikan file sudah diunggah
            if ($request->hasFile('file')) {
                $requestHttp->attach(
                    'file',
                    fopen($request->file('file')->getPathname(), 'r'),
                    $request->file('file')->getClientOriginalName()
                );
            }
    
            // Kirim data ke API
            $response = $requestHttp->post($uploadfilereport, [
                'title' => trim($request->input('title')),
            ]);
    
            // Periksa respons dari API
            if ($response->successful()) {
                Alert::success('Berhasil', 'Laporan berhasil diunggah!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal mengunggah laporan.';
                Alert::error('Gagal', $errorMessage . ' Silakan coba lagi.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
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
}
