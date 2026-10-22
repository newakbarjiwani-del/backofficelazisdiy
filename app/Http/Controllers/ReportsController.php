<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $baseUrl = env('API_BASE_URL');
        $reportsUrl = rtrim(env('REPORTS_URL'), '/');

        $reportsResponse = Http::get("{$baseUrl}/get-report")->json();
        if (!is_array($reportsResponse)) {
            $reportsResponse = [];
        }

        foreach ($reportsResponse as &$report) {
            $report['file_url'] = "{$reportsUrl}/storage/{$report['file_path']}";
            $report['thumbnail_url'] = $report['thumbnail'] ?? null;
            $report['created_at'] = !empty($report['created_at'])
                ? Carbon::parse($report['created_at'])->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s')
                : '-';
        }
        unset($report);

        return view('Reports.index', [
            'reports' => $reportsResponse,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $baseUrl = env('API_BASE_URL');
            $uploadfilereport = "{$baseUrl}/upload-report";

            $request->validate([
                'title' => 'required|string|max:255',
                'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'file' => 'required|file|mimes:pdf|max:10240',
            ]);

            $requestHttp = Http::asMultipart();

            if ($request->hasFile('thumbnail')) {
                $requestHttp->attach(
                    'thumbnail',
                    fopen($request->file('thumbnail')->getPathname(), 'r'),
                    $request->file('thumbnail')->getClientOriginalName()
                );
            }

            if ($request->hasFile('file')) {
                $requestHttp->attach(
                    'file',
                    fopen($request->file('file')->getPathname(), 'r'),
                    $request->file('file')->getClientOriginalName()
                );
            }

            $response = $requestHttp->post($uploadfilereport, [
                'title' => trim($request->input('title')),
            ]);

            if ($response->successful()) {
                Alert::success('Berhasil', 'Laporan berhasil diunggah!');
                return redirect()->back();
            }

            $errorMessage = $response->json()['message'] ?? 'Gagal mengunggah laporan.';
            Alert::error('Gagal', $errorMessage . ' Silakan coba lagi.');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
