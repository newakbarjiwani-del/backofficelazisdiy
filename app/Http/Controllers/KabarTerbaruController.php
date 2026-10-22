<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class KabarTerbaruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseUrl = env('API_BASE_URL');
        $newsUrl = "{$baseUrl}/latestNews/list/campaign";
        $campaignsUrl = "{$baseUrl}/campaigns";

        // Ambil data dari API
        $newsResponse = Http::get($newsUrl)->json();
        $campaignsResponse = Http::get($campaignsUrl)->json(); // Ambil data campaign

        // Menggunakan keyBy untuk memetakan campaign berdasarkan campaign_id
        $campaigns = collect($campaignsResponse['data'])->keyBy('id');

        // Memetakan data berita
        $newss = collect($newsResponse)
            ->map(function ($news) use ($campaigns) {
                // Pencocokan campaign berdasarkan campaign_id menggunakan keyBy
                $campaign = $campaigns->get($news['campaign_id']); // Mendapatkan campaign berdasarkan campaign_id

                // Jika campaign ditemukan, set campaign_name, jika tidak, beri nilai default 'unknown'
                if ($campaign) {
                    $news['campaign_name'] = $campaign['campaign_name'];
                } else {
                    $news['campaign_name'] = 'unknown';
                }

                return $news;
            })
            // ->sortByDesc('created_at') // Urutkan berdasarkan tanggal terbaru
            ->values(); // Reset index setelah pengurutan

        $data = [
            'newss' => $newss,
        ];

        // Debug data untuk memastikan struktur benar
        // dd($data);

        return view('kabarTerbaru.index', $data);
    }

   

    /**
     * Show the form for creating a new resource.
     */



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
       
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
        $baseUrl = env('API_BASE_URL');
        $newsUrledit = "{$baseUrl}/latestNews/campaign/{$id}?_method=PUT";

        $request->validate([
            'latest_news_date' => 'required|date',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
        ]);

        $requestHttp = Http::asMultipart();


        $files = ['image'];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $requestHttp->attach(
                    $file,
                    fopen($request->file($file)->getPathname(), 'r'),
                    $request->file($file)->getClientOriginalName()
                );
            }
        }


        // Mengirim data ke API
        $response = $requestHttp->pOST("{$newsUrledit}", [
            'latest_news_date' => $request->input('latest_news_date'),
            'description' => $request->input('description'),
            
        ]);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Kabar terbaru berhasil diupdate!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal update kabar terbaru. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $deleteNewsurl = "{$baseUrl}/latestNews/delete/{$id}";

        // Kirim request PUT untuk set recomendation
        $response = Http::delete($deleteNewsurl);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Berhasil menghapus kabar terbaru');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal menghapus kabar terbaru. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }
}
