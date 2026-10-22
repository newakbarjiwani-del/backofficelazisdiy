<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ZakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseUrl = env('API_BASE_URL');
        $ZakatUrl = "{$baseUrl}/zakats";

        // Ambil data dari API
        $zakatResponse = Http::get($ZakatUrl)->json();

        $zakats = collect($zakatResponse)
            ->map(function ($zakat) {
                // Validasi format tanggal dan konversi jika diperlukan
                $zakat['created_at'] = Carbon::parse($zakat['created_at'])->toDateTimeString();
                return $zakat;
            })
            // ->sortByDesc('created_at') // Urutkan berdasarkan tanggal terbaru
            ->values(); // Reset index setelah pengurutan

        $data = [
            'zakats' => $zakats,
        ];

        // Debug data untuk memastikan struktur benar
        // dd($data);

        return view('Zakat.index', $data);
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
            $ZakatUrl = "{$baseUrl}/zakats";

            $request->validate([
                'category_name' => 'required|string|max:255',
            ]);
            // Validasi input
            if (empty($request->input('category_name'))) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Nama zakat tidak boleh kosong.'
                ]);
            }

            // Ambil respons JSON dari API
            $response = Http::get($ZakatUrl);

            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API');
            }

            $zakatResponse = $response->json();
            $existingzakat = collect($zakatResponse);

            // Cek apakah nama kategori sudah ada (case insensitive)
            $isDuplicate = $existingzakat->contains(function ($category) use ($request) {
                return strtolower($category['category_name']) === strtolower($request->input('category_name'));
            });

            return response()->json([
                'exists' => $isDuplicate,
                'message' => $isDuplicate ? 'Kategori zakat ini sudah ada.' : ''
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
            $ZakatUrl = "{$baseUrl}/zakats";

            $request->validate([
                'category_name' => 'required|string|max:255',
                'thumbnail' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            ]);
            // Cek duplikasi sebelum menyimpan
            $checkResponse = Http::get($ZakatUrl);

            if ($checkResponse->successful()) {
                $existingCategories = collect($checkResponse->json());

                $isDuplicate = $existingCategories->contains(function ($category) use ($request) {
                    return strtolower($category['category_name']) === strtolower($request->input('category_name'));
                });

                if ($isDuplicate) {
                    Alert::error('Gagal', 'Kategori zakat ini sudah ada.');
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

            // Tambahkan data kategori zakat ke dalam request
            $response = $requestHttp->post($ZakatUrl, [
                'category_name' => trim($request->input('category_name')),
            ]);

            if ($response->successful()) {
                Alert::success('Berhasil', 'Kategori zakat berhasil dibuat!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal membuat kategori zakat.';
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
    // public function update(Request $request, string $id)
    // {
    //     try {
    //         $baseUrl = env('API_BASE_URL');
    //         $ZakatUrl = "{$baseUrl}/zakats";

    //         $request->validate([
    //             'category_name' => 'required|string|max:255',
    //             'thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
    //         ]);

    //         // Validasi duplikasi
    //         $checkResponse = Http::get($ZakatUrl);
    //         if ($checkResponse->successful()) {
    //             $existingCategories = collect($checkResponse->json());
    //             $isDuplicate = $existingCategories->contains(function ($category) use ($request, $id) {
    //                 return strtolower($category['category_name']) === strtolower($request->input('category_name')) && $category['id'] != $id;
    //             });
    //             if ($isDuplicate) {
    //                 Alert::error('Gagal', 'Kategori zakat ini sudah ada.');
    //                 return redirect()->back()->withInput();
    //             }
    //         }

    //         // Siapkan data
    //         $data = [
    //             'category_name' => trim($request->input('category_name')),
    //         ];

    //         $requestHttp = $request->hasFile('thumbnail') ? Http::asMultipart() : Http::withHeaders([]);

    //         if ($request->hasFile('thumbnail')) {
    //             $requestHttp->attach(
    //                 'thumbnail',
    //                 fopen($request->file('thumbnail')->getPathname(), 'r'),
    //                 $request->file('thumbnail')->getClientOriginalName()
    //             );
    //         }

    //         // Kirim permintaan ke API
    //         $response = $requestHttp->put("{$ZakatUrl}/{$id}", $data);

    //         if ($response->successful()) {
    //             Alert::success('Berhasil', 'Kategori zakat berhasil diperbarui!');
    //             return redirect()->back();
    //         } else {
    //             $errorMessage = $response->json()['message'] ?? 'Gagal memperbarui kategori zakat.';
    //             Alert::error('Gagal', $errorMessage . ' Silakan coba lagi.');
    //             return redirect()->back()->withInput();
    //         }
    //     } catch (\Exception $e) {
    //         Alert::error('Gagal', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    //         return redirect()->back()->withInput();
    //     }
    // }

    public function update(Request $request, string $id)
    {
        try {
            $baseUrl = env('API_BASE_URL');
            $zakatUrl = "{$baseUrl}/zakats";

            $request->validate([
                'category_name' => 'required|string|max:255',
                'thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Cek duplikasi kategori
            $checkResponse = Http::get($zakatUrl);
            if ($checkResponse->successful()) {
                $existingCategories = collect($checkResponse->json());
                $isDuplicate = $existingCategories->contains(function ($category) use ($request, $id) {
                    return strtolower($category['category_name']) === strtolower($request->input('category_name')) && $category['id'] != $id;
                });

                if ($isDuplicate) {
                    Alert::error('Gagal', 'Kategori zakat ini sudah ada.');
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
                    ->post("{$zakatUrl}/{$id}?_method=PUT", $data);
            } else {
                // Send request without file
                $response = Http::post("{$zakatUrl}/{$id}?_method=PUT", $data);
            }

            // dd($response->json());
            // Periksa hasil API
            if ($response->successful()) {
                Alert::success('Berhasil', 'Kategori zakat berhasil diperbarui!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal memperbarui kategori zakat.';
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
