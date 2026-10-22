<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class InfakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseUrl = env('API_BASE_URL');
        $infakUrl = "{$baseUrl}/infaks";

        // Ambil data dari API
        $infakResponse = Http::get($infakUrl)->json();

        $infaks = collect($infakResponse)
            ->map(function ($infak) {
                // Validasi format tanggal dan konversi jika diperlukan
                $infak['created_at'] = Carbon::parse($infak['created_at'])->toDateTimeString();
                return $infak;
            })
            // ->sortByDesc('created_at') // Urutkan berdasarkan tanggal terbaru
            ->values(); // Reset index setelah pengurutan

        $data = [
            'infaks' => $infaks,
        ];

        // Debug data untuk memastikan struktur benar
        // dd($data);

        return view('Infak.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function checkCategory(Request $request)
    {
        try {
            $baseUrl = env('API_BASE_URL');
            $infakUrl = "{$baseUrl}/infaks";

            $request->validate([
                'category_name' => 'required|string|max:255',
            ]);
            // Validasi input
            if (empty($request->input('category_name'))) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Nama infak tidak boleh kosong.'
                ]);
            }

            // Ambil respons JSON dari API
            $response = Http::get($infakUrl);

            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API');
            }

            $infakResponse = $response->json();
            $existinginfak = collect($infakResponse);

            // Cek apakah nama kategori sudah ada (case insensitive)
            $isDuplicate = $existinginfak->contains(function ($category) use ($request) {
                return strtolower($category['category_name']) === strtolower($request->input('category_name'));
            });

            return response()->json([
                'exists' => $isDuplicate,
                'message' => $isDuplicate ? 'Kategori infak ini sudah ada.' : ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'message' => 'Terjadi kesalahan saat memeriksa kategori.'
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $baseUrl = env('API_BASE_URL');
            $infakUrl = "{$baseUrl}/infaks";

            $request->validate([
                'category_name' => 'required|string|max:255',
                'thumbnail' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            ]);
            // Cek duplikasi sebelum menyimpan
            $checkResponse = Http::get($infakUrl);

            if ($checkResponse->successful()) {
                $existingCategories = collect($checkResponse->json());

                $isDuplicate = $existingCategories->contains(function ($category) use ($request) {
                    return strtolower($category['category_name']) === strtolower($request->input('category_name'));
                });

                if ($isDuplicate) {
                    Alert::error('Gagal', 'Kategori infak ini sudah ada.');
                    return redirect()->back()->withInput();
                }
            }

            // Siapkan permintaan HTTP menggunakan asMultipart
            $requestHttp = Http::asMultipart();

            // Daftar file yang mungkin diunggah
            $files = ['thumbnail'];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $requestHttp->attach(
                        $file,
                        fopen($request->file($file)->getPathname(), 'r'),
                        $request->file($file)->getClientOriginalName()
                    );
                }
            }

            // Tambahkan data kategori infak ke dalam request
            $response = $requestHttp->post($infakUrl, [
                'category_name' => trim($request->input('category_name')),
            ]);

            if ($response->successful()) {
                Alert::success('Berhasil', 'Kategori infak berhasil dibuat!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal membuat kategori infak.';
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
        try {
            $baseUrl = env('API_BASE_URL');
            $infakUrl = "{$baseUrl}/infaks";

            $request->validate([
                'category_name' => 'required|string|max:255',
                'thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Cek duplikasi kategori
            $checkResponse = Http::get($infakUrl);
            if ($checkResponse->successful()) {
                $existingCategories = collect($checkResponse->json());
                $isDuplicate = $existingCategories->contains(function ($category) use ($request, $id) {
                    return strtolower($category['category_name']) === strtolower($request->input('category_name')) && $category['id'] != $id;
                });

                if ($isDuplicate) {
                    Alert::error('Gagal', 'Kategori infak ini sudah ada.');
                    return redirect()->back()->withInput();
                }
            }

            // Siapkan data untuk dikirim
            $data = [
                'category_name' => trim($request->input('category_name')),
            ];

            // If there is a file for thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                // Send request with multipart (file and data)
                $response = Http::asMultipart()
                    ->attach('thumbnail', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                    ->post("{$infakUrl}/{$id}?_method=PUT", $data);
            } else {
                // Send request without file
                $response = Http::post("{$infakUrl}/{$id}?_method=PUT", $data);
            }

            // dd($response->json());
            // Periksa hasil API
            if ($response->successful()) {
                Alert::success('Berhasil', 'Kategori infak berhasil diperbarui!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal memperbarui kategori infak.';
                Alert::error('Gagal', $errorMessage . ' Silakan coba lagi.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {

            Alert::error('Gagal', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
