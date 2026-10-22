<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('auth.login');
    }


    /**
     * Show the form for creating a new resource.
     */

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('name', 'password');
    //     $baseUrl = env('API_BASE_URL');
    //     $loginAdmin = "{$baseUrl}/login-admin";

    //     try {
    //         // // Kirim request login API
    //         $response = Http::asJson()->post($loginAdmin, $credentials);
    //         //   $response = Http::timeout(30)->asJson()->post($loginAdmin, $credentials);

    //         // Cek response
    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             // Simpan token ke session
    //             $request->session()->put('token', $responseData['token']);

    //             // Simpan user data ke session
    //             $request->session()->put('user', $responseData['user']);

    //             // Regenerate session
    //             $request->session()->regenerate();

    //             // Tampilkan alert sebelum redirect
    //             Alert::success('Berhasil', 'Login berhasil!')->persistent(true);

    //             return redirect()->route('dashboard.index');
    //         }

    //         // Jika login gagal
    //         Alert::error('Gagal', 'Login gagal. Silakan periksa kembali name atau password Anda.')->persistent(true);
    //         return back()->withInput($request->except('password'));
    //     } catch (\Exception $e) {
    //         // Tangani error koneksi atau server
    //         Alert::error('Kesalahan', 'Terjadi kesalahan: ' . $e->getMessage())->persistent(true);
    //         return back();
    //     }
    // }

    public function login(Request $request)
    {
        // Ambil kredensial dari request
        $credentials = $request->only('name', 'password');

        // URL API login
        $baseUrl = env('API_BASE_URL');
        $loginAdmin = "{$baseUrl}/login-admin";

        // Jika token sudah ada di session, arahkan ke dashboard
        if ($request->session()->has('token')) {
            return redirect()->route('dashboard.index');
        }

        try {
            // Kirim request login ke API
            $response = Http::asJson()->post($loginAdmin, $credentials);

            // Cek jika response berhasil
            if ($response->successful()) {
                $responseData = $response->json();

                // Cek jika token dan user ada dalam response
                if (isset($responseData['token']) && isset($responseData['user'])) {
                    // Simpan token ke session
                    $request->session()->put('token', $responseData['token']);
                    // Simpan data user ke session
                    $request->session()->put('user', $responseData['user']);

                    // Regenerasi session untuk menghindari session fixation
                    $request->session()->regenerate();

                    // Tampilkan alert login berhasil
                    Alert::success('Berhasil', 'Login berhasil!')->persistent(true);

                    // Redirect ke halaman dashboard
                    return redirect()->route('dashboard.index');
                } else {
                    // Jika tidak ada token atau user
                    Alert::error('Gagal', 'Data login tidak valid.')->persistent(true);
                    return back()->withInput($request->except('password'));
                }
            }

            // Jika login gagal
            Alert::error('Gagal', 'Login gagal. Silakan periksa kembali nama atau password Anda.')->persistent(true);
            return back()->withInput($request->except('password'));
        } catch (\Exception $e) {
            // Tangani kesalahan API atau koneksi
            Alert::error('Kesalahan', 'Terjadi kesalahan: ' . $e->getMessage())->persistent(true);
            return back();
        }
    }

    // Jika perlu, buat method logout untuk menghapus session
    // public function logout(Request $request)
    // {
    //     $request->session()->flush();  // Menghapus semua session
    //     Alert::success('Berhasil', 'Anda berhasil logout.')->persistent(true);
    //     return redirect()->route('login');
    // }




    // public function register(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone_number' => 'required|numeric', // Added unique validation
    //         'password' => 'required|string|min:6',
    //     ]);

    //     // API URL
    //     $baseUrl = env('API_BASE_URL');
    //     $registerAdmin = "{$baseUrl}/register-admin";

    //     try {
    //         // Kirim request API
    //         $response = Http::asJson()->post($registerAdmin, [
    //             'name' => $request->name,
    //             'phone_number' => $request->phone_number,
    //             'password' => $request->password,
    //         ]);

    //         // Check for specific error scenarios
    //         if ($response->failed()) {
    //             $errorBody = $response->json();

    //             // Handle phone number already exists
    //             if (isset($errorBody['errors']['phone_number'])) {
    //                 Alert::error('Gagal', 'Nomor telepon sudah terdaftar.');
    //                 return back()->withInput($request->except('password'));
    //             }

    //             // Generic error handling
    //             Alert::error('Gagal', 'Register gagal! Silakan coba lagi.');
    //             return back()->withInput($request->except('password'));
    //         }

    //         // Successful registration
    //         Alert::success('Berhasil', 'Register berhasil! Silakan login.');
    //         return redirect()->route('login.index');
    //     } catch (\Exception $e) {
    //         // Catch any unexpected errors
    //         Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
    //         return back()->withInput($request->except('password'));
    //     }
    // }

    public function logout(Request $request)
    {
        session()->forget('token');
        session()->forget('user');
        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Clear authentication
        Auth::logout();

        // Show logout success alert
        Alert::success('Berhasil', 'Anda berhasil logout.');

        // Redirect to login page
        return redirect()->route('login.index');
    }

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
