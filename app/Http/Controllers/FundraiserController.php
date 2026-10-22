<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FundraiserController extends Controller
{
    public function index(Request $request)
    {
        $baseUrl = rtrim(env('API_BASE_URL'), '/');
        $response = Http::timeout(30)->get("{$baseUrl}/fundraiser/list");
        $payload = $response->successful() ? $response->json() : [];
        $fundraisers = is_array($payload['data'] ?? null) ? $payload['data'] : [];

        return view('fundraiser.index', [
            'fundraisers' => $fundraisers,
        ]);
    }
}
