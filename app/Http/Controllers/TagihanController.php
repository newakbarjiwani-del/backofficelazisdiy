<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $page = $request->get('page', 1);
    //     $category = $request->get('category', 'all');
    //     $success = $request->get('success', 'all');


    //     $baseUrl = env('API_BASE_URL');  // Base URL API (misalnya untuk mengambil laporan)
    //     $billingurl = "{$baseUrl}/billings";
    //     $zakatUrl = "{$baseUrl}/zakats";
    //     $infakUrl = "{$baseUrl}/infaks";


    //     // Build query parameters for transactions
    //     $queryParams = ['page' => $page];
    //     if ($category !== 'all') {
    //         $queryParams['category'] = $category;
    //     }
    //     if ($success !== 'all') {
    //         $queryParams['success'] = $success;
    //     }

    //     // Fetch transactions data
    //     $billingresponse = Http::get($billingurl, $queryParams)->json();
    //     // dd($billingresponse);
    //     $billings = collect($billingresponse['data'] ?? [])
    //         ->filter(fn($bills) => !empty($bills['billing_amount']))
    //         ->map(function ($bills) {
    //             if (isset($bills['campaign']['campaign_name'])) {
    //                 $bills['campaign_name'] = $bills['campaign']['campaign_name'] ?? 'No Campaign';
    //             } elseif (isset($bills['zakat']['category_name'])) {
    //                 $bills['zakat_name'] = $bills['zakat']['category_name'] ?? 'No zakat';
    //             } elseif (isset($bills['infak']['category_name'])) {
    //                 $bills['infak_name'] = $bills['infak']['category_name'] ?? 'No infak';
    //             }


    //             return $bills;
    //         });
    //     // Fetch additional data (zakats and infaks)
    //     $zakats = Http::get($zakatUrl)->json();
    //     $infaks = Http::get($infakUrl)->json();

    //     // Merge transactions, zakats, and infaks into one collection
    //     $allData = $billings
    //         ->merge(collect($zakats)->filter(fn($item) => !empty($item['billing_amount'])) // Hanya data dengan transaksi
    //             ->map(function ($item) {
    //                 $item['category'] = 'zakat';
    //                 $item['category_name'] = $item['category_name'] ?? 'Zakat';
    //                 return $item;
    //             }))
    //         ->merge(collect($infaks)->filter(fn($item) => !empty($item['billing_amount'])) // Hanya data dengan transaksi
    //             ->map(function ($item) {
    //                 $item['category'] = 'infak';
    //                 $item['category_name'] = $item['category_name'] ?? 'Infak';
    //                 return $item;
    //             }));
    //     // // Apply category filter if specified
    //     // $allData = $allData->when($category !== 'all', function ($query) use ($category) {
    //     //     return $query->where('category', $category);
    //     // });

    //     // Apply category and success filters if specified
    //     $allData = $allData
    //         ->when($category !== 'all', fn($query) => $query->where('category', $category))
    //         ->when($success !== 'all', function ($query) use ($success) {
    //             if ($success == 1) {
    //                 return $query->where('success', 1); // 1 untuk sukses
    //             } elseif ($success == 0) {
    //                 return $query->where('success', 0); // 0 untuk gagal
    //             }
    //         });
    //     // dd($success == 'gagal', $allData->toArray());



    //     // Sort data by transaction_date (if exists) or created_at
    //     $allData = $allData->sortByDesc('billing_date') ?: $allData->sortByDesc('created_at');


    //     // Get unique categories for filter dropdown
    //     $categories = collect(['all', 'zakat', 'infak', 'campaign'])
    //         ->merge($allData->pluck('category'))
    //         ->unique()
    //         ->values(); // Reset index untuk memastikan struktur bersih

    //     $succes = collect(['all', 'sukses', 'gagal'])
    //         ->merge(
    //             $allData->pluck('success')->map(fn($value) => $value == 1 ? 'sukses' : 'gagal')
    //         )
    //         ->unique()
    //         ->values();



    //     // dd($succes->toArray());



    //     $paginationData = [
    //         'current_page' => $billingresponse['current_page'] ?? 1,
    //         'last_page' => $billingresponse['last_page'] ?? 1,
    //         'next_page_url' => $billingresponse['next_page_url'] ?? null,
    //         'prev_page_url' => $billingresponse['prev_page_url'] ?? null,
    //         'per_page' => $billingresponse['per_page'] ?? $allData->count(),
    //         'total' => $billingresponse['total'],
    //     ];
    //     // Return JSON for AJAX requests
    //     if ($request->ajax() || $request->get('ajax')) {
    //         return response()->json([
    //             'billings' => $allData->values(), // Reset array keys
    //             'pagination' => $paginationData
    //         ]);
    //     }
    //     // Return view for regular requests
    //     return view('tagihan.index', [
    //         'billings' => $allData,
    //         'categories' => $categories,
    //         'succes' => $succes,
    //         'pagination' => $paginationData,
    //         'currentCategory' => $category,
    //     ]);
    // }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $category = $request->get('category', 'all');
        $success = $request->get('success', 'all');  // Defaultkan ke 'all' jika tidak ada nilai

        $baseUrl = env('API_BASE_URL');  // Base URL API (misalnya untuk mengambil laporan)
        $billingurl = "{$baseUrl}/billings";
        $zakatUrl = "{$baseUrl}/zakats";
        $infakUrl = "{$baseUrl}/infaks";

        // Build query parameters for transactions
        $queryParams = ['page' => $page];
        if ($category !== 'all') {
            $queryParams['category'] = $category;
        }
        if ($success !== 'all') {
            $queryParams['success'] = $success;
        }

        // Fetch transactions data
        $billingresponse = Http::get($billingurl, $queryParams)->json();
        $billings = collect($billingresponse['data'] ?? [])
            ->filter(fn($bills) => !empty($bills['billing_amount']))
            ->map(function ($bills) {
                $bills['id'] = $bills['billing_id'] ?? null;
                if (isset($bills['campaign']['campaign_name'])) {
                    $bills['campaign_name'] = $bills['campaign']['campaign_name'] ?? 'No Campaign';
                } elseif (isset($bills['zakat']['category_name'])) {
                    $bills['zakat_name'] = $bills['zakat']['category_name'] ?? 'No zakat';
                } elseif (isset($bills['infak']['category_name'])) {
                    $bills['infak_name'] = $bills['infak']['category_name'] ?? 'No infak';
                }
                $bills['success'] = $bills['success'] ?? 1; // Default to success if not exists
                return $bills;
            });

        // Fetch additional data (zakats and infaks)
        $zakats = Http::get($zakatUrl)->json();
        $infaks = Http::get($infakUrl)->json();

        // Tambahkan field 'success' jika tidak ada
        $zakats = array_map(function ($item) {
            $item['success'] = $item['success'] ?? 1; // Default to success
            return $item;
        }, $zakats);

        $infaks = array_map(function ($item) {
            $item['success'] = $item['success'] ?? 1; // Default to success
            return $item;
        }, $infaks);

        // Merge transactions, zakats, and infaks into one collection
        $allData = $billings
            ->merge(collect($zakats)->filter(fn($item) => !empty($item['billing_amount']))
                ->map(function ($item) {
                    $item['category'] = 'zakat';
                    $item['category_name'] = $item['category_name'] ?? 'Zakat';
                    return $item;
                }))
            ->merge(collect($infaks)->filter(fn($item) => !empty($item['billing_amount']))
                ->map(function ($item) {
                    $item['category'] = 'infak';
                    $item['category_name'] = $item['category_name'] ?? 'Infak';
                    return $item;
                }));

        // Apply category and success filters if specified
        $allData = $allData
            ->when($category !== 'all', fn($query) => $query->where('category', $category))
            ->when($success !== 'all', function ($query) use ($success) {
                if ($success === '1') {
                    return $query->where('success', 1); // 1 untuk sukses
                } elseif ($success === '0') {
                    return $query->where('success', 0); // 0 untuk gagal
                }
            });

        // // Sort data by billing_date or created_at
        // $allData = $allData->sortByDesc(function ($item) {
        //     return $item['billing_date'] ?? $item['created_at'];
        // });

        // Get unique categories for filter dropdown
        $categories = collect(['all', 'zakat', 'infak', 'campaign'])
            ->merge($allData->pluck('category'))
            ->unique()
            ->values();

        $succes = collect(['all', 'sukses', 'gagal'])
            ->merge(
                $allData->pluck('success')->map(fn($value) => $value == 1 ? 'sukses' : 'gagal')
            )
            ->unique()
            ->values();

        $paginationData = [
            'current_page' => $billingresponse['current_page'] ?? 1,
            'last_page' => $billingresponse['last_page'] ?? 1,
            'next_page_url' => $billingresponse['next_page_url'] ?? null,
            'prev_page_url' => $billingresponse['prev_page_url'] ?? null,
            'per_page' => $billingresponse['per_page'] ?? $allData->count(),
            'total' => $billingresponse['total'],
        ];

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'billings' => $allData->values(), // Reset array keys
                'pagination' => $paginationData
            ]);
        }

        // Return view for regular requests
        return view('tagihan.index', [
            'billings' => $allData,
            'categories' => $categories,
            'succes' => $succes,
            'pagination' => $paginationData,
            'currentCategory' => $category,
        ]);
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
