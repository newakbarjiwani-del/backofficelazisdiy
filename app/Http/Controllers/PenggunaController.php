<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $sortField = $request->get('sortField', 'name'); // Default sorting field
        $sortDirection = $request->get('sortDirection', 'asc');
        $search = $request->get('search', '');


        $baseUrl = env('API_BASE_URL');
        $usersUrl = "{$baseUrl}/users?page={$page}";

         // Tambahkan parameter search jika ada
         if (!empty($search)) {
            $usersUrl .= "&search={$search}";
        }


        $usersResponse = Http::get($usersUrl)->json();
        // Sort data di sisi klien
        $users = collect($usersResponse['data'])
            // ->sortByDesc('created_at')
            ->filter(function ($user) use ($search) {
                return empty($search) || str_contains(strtolower($user['name']), strtolower($search));
            })
            ->sortBy($sortField, SORT_REGULAR, $sortDirection === 'desc')
            ->values()
            ->toArray();
            
        if ($request->ajax()) {
            return response()->json([
                'users' => $users,
                'pagination' => [
                    'current_page' => $usersResponse['current_page'],
                    'last_page' => $usersResponse['last_page'],
                    'total' => $usersResponse['total'],
                    'next_page_url' => $usersResponse['next_page_url'],
                    'prev_page_url' => $usersResponse['prev_page_url'],
                    'per_page' => $usersResponse['per_page'],
                ],
            ]);
        }

        return view('pengguna.index', [
            'users' => $users,
            'pagination' => [
                'current_page' => $usersResponse['current_page'],
                'last_page' => $usersResponse['last_page'],
                'next_page_url' => $usersResponse['next_page_url'],
                'prev_page_url' => $usersResponse['prev_page_url'],
                'per_page' => $usersResponse['per_page'],
                'total' => $usersResponse['total'],
            ],
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function search(Request $request)
    {
        return $this->index($request);
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
