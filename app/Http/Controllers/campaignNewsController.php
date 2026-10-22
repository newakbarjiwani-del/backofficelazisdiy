<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;


class CampaignNewsController extends Controller
{
   

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $categoryId = $request->get('category_id', '');

        $baseUrl = env('API_BASE_URL');
        $campaignsUrl = "{$baseUrl}/campaigns?page={$page}";


        // Tambahkan parameter category_id jika ada
        if (!empty($categoryId)) {
            $campaignsUrl .= "&category_id={$categoryId}";
        }

        // Tambahkan parameter search jika ada
        if (!empty($search)) {
            $campaignsUrl .= "&search={$search}";
        }

        $categoriesUrl = "{$baseUrl}/campaign-categories";

        // Fetch data dari API
        $campaignsResponse = Http::get($campaignsUrl)->json();
        $categoriesResponse = Http::get($categoriesUrl)->json();
        // $categoriesResponse = collect(Http::get($categoriesUrl)->json()); // Ubah menjadi koleksi


        $campaigns = collect($campaignsResponse['data'])
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
            // ->sortByDesc('created_at')
            ->values();
          
        $data = [
            'campaigns' => $campaigns,
            'categories' => $categoriesResponse,
            'pagination' => [
                'current_page' => $campaignsResponse['current_page'],
                'last_page' => $campaignsResponse['last_page'],
                'next_page_url' => $campaignsResponse['next_page_url'],
                'prev_page_url' => $campaignsResponse['prev_page_url'],
                'per_page' => $campaignsResponse['per_page'],
                'total' => $campaignsResponse['total'],
            ],
        ];

        return view('kabarTerbaru.news.index', $data);
    }

    // public function store(Request $request)

    // {
       
    // }

    public function setNews($id, Request $request)
    {
        $baseUrl = env('API_BASE_URL');
        $newsUrl = "{$baseUrl}/latestNews/campaign";


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
        $response = $requestHttp->post("{$newsUrl}/{$id}", [
            'latest_news_date' => $request->input('latest_news_date'),
            'description' => $request->input('description'),
            
        ]);
        // dd($id);
        // Log::info('Data yang dikirim ke API:', [
        //     'latest_news_date' => $request->input('latest_news_date'),
        //     'description' => $request->input('description'),
        // ]);
        
        // Log::info('Respon API:', [
        //     'status' => $response->status(),
        //     'body' => $response->body(),
        // ]);
        
        

        // dd($response);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Kabar terbaru berhasil dibuat!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal membuat kabar terbaru. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        
    }

 
}
