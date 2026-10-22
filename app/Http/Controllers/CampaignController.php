<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CampaignController extends Controller
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
        // $categoriesResponse = Http::get($categoriesUrl)->json();
        $categoriesResponse = collect(Http::get($categoriesUrl)->json()); // Ubah menjadi koleksi

        // Filter hanya kampanye dengan priority = 0
        $filteredCampaigns = collect($campaignsResponse['data'])
            ->filter(function ($campaign) {
                return $campaign['priority'] == 0 && $campaign['recomendation'] == 0 && $campaign['active'] == 1;
            });

        $campaigns = $filteredCampaigns
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
            ->values();
        // dd(session()->all());


        $data = [
            'campaigns' => $campaigns,
            'categories' => $categoriesResponse,
            'pagination' => [
                'current_page' => $campaignsResponse['current_page'],
                'last_page' => $campaignsResponse['last_page'],
                'next_page_url' => $campaignsResponse['next_page_url'],
                'prev_page_url' => $campaignsResponse['prev_page_url'],
                'per_page' => $campaignsResponse['per_page'],
                'total' => $filteredCampaigns->count(),
            ],
        ];

        return view('campaign.index', $data);
    }

    public function store(Request $request)

    {
        $baseUrl = env('API_BASE_URL');
        $campaignsUrl = "{$baseUrl}/campaigns";

        $request->validate([
            'campaign_thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_1' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_2' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_3' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_category_id' => 'required|integer',
            'campaign_name' => 'required|string|max:255',
            'campaign_code' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'priority' => 'nullable|boolean',
            'fundraiser' => 'required|string|max:255',
            'fundraiser_image' => 'file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $requestHttp = Http::asMultipart();

        $files = ['campaign_thumbnail', 'campaign_image_1', 'campaign_image_2', 'campaign_image_3', 'fundraiser_image'];

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
        $response = $requestHttp->post("{$campaignsUrl}", [
            'campaign_category_id' => $request->input('campaign_category_id'),
            'campaign_name' => $request->input('campaign_name'),
            'campaign_code' => $request->input('campaign_code'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'target_amount' => $request->input('target_amount'),
            'start_date' => $request->input('start_date'),
            'priority' => $request->input('priority'),
            'fundraiser' => $request->input('fundraiser'),
        ]);

        // dd($response);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Campaign berhasil dibuat!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal membuat campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $campaignsUrl = "{$baseUrl}/campaigns/{$id}?_method=PUT";

        $request->validate([
            'campaign_thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_1' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_2' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_3' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_category_id' => 'required|integer',
            'campaign_name' => 'required|string|max:255',
            'campaign_code' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'fundraiser' => 'required|string|max:255',
            'fundraiser_image' => 'file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mulai buat array data yang akan dikirimkan
        $updateData = [
            'campaign_category_id' => $request->input('campaign_category_id'),
            'campaign_name' => $request->input('campaign_name'),
            'campaign_code' => $request->input('campaign_code'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'target_amount' => $request->input('target_amount'),
            'start_date' => $request->input('start_date'),
            'fundraiser' => $request->input('fundraiser'),
        ];

        // Periksa file yang diupload dan tambahkan ke data jika ada
        if ($request->hasFile('campaign_thumbnail')) {
            $updateData['campaign_thumbnail'] = fopen($request->file('campaign_thumbnail')->getPathname(), 'r');
        }

        if ($request->hasFile('campaign_image_1')) {
            $updateData['campaign_image_1'] = fopen($request->file('campaign_image_1')->getPathname(), 'r');
        }

        if ($request->hasFile('campaign_image_2')) {
            $updateData['campaign_image_2'] = fopen($request->file('campaign_image_2')->getPathname(), 'r');
        }

        if ($request->hasFile('campaign_image_3')) {
            $updateData['campaign_image_3'] = fopen($request->file('campaign_image_3')->getPathname(), 'r');
        }

        if ($request->hasFile('fundraiser_image')) {
            $updateData['fundraiser_image'] = fopen($request->file('fundraiser_image')->getPathname(), 'r');
        }

        // Kirim data ke API untuk update dengan metode PUT
        $response = Http::asMultipart()->post($campaignsUrl, $updateData);

        // dd($response->json());

        // Menangani respons dari API
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Campaign updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update campaign. ' . $response->body());
        }
    }

    public function campaignActive(Request $request)
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
        // $categoriesResponse = Http::get($categoriesUrl)->json();
        $categoriesResponse = collect(Http::get($categoriesUrl)->json()); // Ubah menjadi koleksi

        // Filter hanya kampanye dengan priority = 0
        $filteredCampaigns = collect($campaignsResponse['data'])
            ->filter(function ($campaign) {
                return $campaign['priority'] == 0 && $campaign['recomendation'] == 0 && $campaign['active'] == 1;
            });

        $campaigns = $filteredCampaigns
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
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
                'total' => $filteredCampaigns->count(),
            ],
        ];

        return view('campaign.campaignActive.index', $data);
    }

    public function campNonActive(Request $request)
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
        // $categoriesResponse = Http::get($categoriesUrl)->json();
        $categoriesResponse = collect(Http::get($categoriesUrl)->json()); // Ubah menjadi koleksi

        // Filter hanya kampanye dengan priority = 0
        $filteredCampaigns = collect($campaignsResponse['data'])
            ->filter(function ($campaign) {
                return $campaign['priority'] == 0 && $campaign['recomendation'] == 0 && $campaign['active'] == 0;
            });

        $campaigns = $filteredCampaigns
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
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
                'total' => $filteredCampaigns->count(),
            ],
        ];

        return view('campaign.campaignNonActive.index', $data);
    }


    public function setaktif(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $setaktif = "{$baseUrl}/campaign/set-active/{$id}";

        // Kirim request PUT untuk set priority
        $response = Http::put($setaktif);

        if ($response->successful()) {
            Alert::success('Berhasil', 'campaign berhasil diaktifkan!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal mengaktifkan campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function unaktif(string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $unsetaktif = "{$baseUrl}/campaign/unset-active/{$id}";

        // Kirim request PUT untuk set priority
        $response = Http::put($unsetaktif);

        if ($response->successful()) {
            Alert::success('Berhasil', 'campaign berhasil dinonaktifkan');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal menonaktifkan campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }
}
