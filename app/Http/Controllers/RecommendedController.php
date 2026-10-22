<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class RecommendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchrecomendation = $request->get('search', '');
        $categoryIdrecomendation = $request->get('category_id', '');

        $baseUrl = env('API_BASE_URL');
        $campaignsUrlrecomendation = "{$baseUrl}/campaign/get-recomendation";

        // Tambahkan parameter category_id jika ada
        if (!empty($categoryIdrecomendation)) {
            $campaignsUrlrecomendation .= "&category_id={$categoryIdrecomendation}";
        }

        // Tambahkan parameter search jika ada
        if (!empty($searchrecomendation)) {
            $campaignsUrlrecomendation .= "&search={$searchrecomendation}";
        }

        $categoriesUrlrecomendation = "{$baseUrl}/campaign-categories";

        // Fetch data dari API
        $campaignsResponserecomendation = Http::get($campaignsUrlrecomendation)->json();
        // $categoriesResponse = Http::get($categoriesUrlrecomendation)->json();
        $categoriesResponserecomendation = collect(Http::get($categoriesUrlrecomendation)->json()); // Ubah menjadi koleksi

        $campaignsrecomendation = collect($campaignsResponserecomendation)
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
            ->values();

        $data = [
            'campaigns' => $campaignsrecomendation,
            'categories' => $categoriesResponserecomendation,
        ];

        return view('campaign.campaignrecomend.index', $data);
    }

    public function setRecomendtion(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $setrecomendationUrl = "{$baseUrl}/campaign/set-recomendation/{$id}";

        // Kirim request PUT untuk set recomendation
        $response = Http::put($setrecomendationUrl);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Rekomendasi campaign berhasil diaktifkan!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal mengaktifkan rekomendasi campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }
    public function unsetRecomendtion(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $unsetrecomendationUrl = "{$baseUrl}/campaign/unset-recomendation/{$id}";

        // Kirim request PUT untuk set recomendation
        $response = Http::put($unsetrecomendationUrl);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Rekomendasi campaign berhasil dinonaktifkan');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal menonaktifkan rekomendasi campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    

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
}
