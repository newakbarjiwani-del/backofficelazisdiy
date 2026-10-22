<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchpriority = $request->get('search', '');
        $categoryIdpriority = $request->get('category_id', '');

        $baseUrl = env('API_BASE_URL');
        $campaignsUrlpriority = "{$baseUrl}/campaign/get-priority?";

        // Tambahkan parameter category_id jika ada
        if (!empty($categoryIdpriority)) {
            $campaignsUrlpriority .= "&category_id={$categoryIdpriority}";
        }

        // Tambahkan parameter search jika ada
        if (!empty($searchpriority)) {
            $campaignsUrlpriority .= "&search={$searchpriority}";
        }

        $categoriesUrlpriority = "{$baseUrl}/campaign-categories";

        // Fetch data dari API
        $campaignsResponsepriority = Http::get($campaignsUrlpriority)->json();
        // $categoriesResponse = Http::get($categoriesUrlpriority)->json();
        $categoriesResponsepriority = collect(Http::get($categoriesUrlpriority)->json()); // Ubah menjadi koleksi

        $campaignspriority = collect($campaignsResponsepriority)
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
            ->values();

        $data = [
            'campaigns' => $campaignspriority,
            'categories' => $categoriesResponsepriority,
        ];

        return view('campaign.campaignPriority.index', $data);
    }

    public function setPriority(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $setPriorityUrl = "{$baseUrl}/campaign/set-priority/{$id}";

        // Kirim request PUT untuk set priority
        $response = Http::put($setPriorityUrl);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Priority campaign berhasil diaktifkan!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal mengaktifkan priority campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function unsetPriority(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $unsetPriorityUrl = "{$baseUrl}/campaign/unset-priority/{$id}";

        // Kirim request PUT untuk set priority
        $response = Http::put($unsetPriorityUrl);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Priority campaign berhasil dinonaktifkan');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal menonaktifkan priority campaign. Silakan coba lagi.');
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
