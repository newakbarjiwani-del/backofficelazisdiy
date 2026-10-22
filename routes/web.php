<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignNewsController;
use App\Http\Controllers\CategoryCampaignController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfakController;
use App\Http\Controllers\KabarTerbaruController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\RecommendedController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TagihanController;

// Route::get('/', function () {
//     return view('admin.main');
// })->name('dashboard.index');
// Route::get('/dashboard', function () {
//     return view('admin.main');
// })->name('dashboard.index');
// Route::post('/register-admin', [AuthController::class, 'register'])->name('register.index');
Route::get('/', [AuthController::class, 'index'])->name('login.index');
Route::post('/login-admin', [AuthController::class, 'login'])->name('logins.index');
Route::get('/login-admin', [AuthController::class, 'login'])->name('logins.index');

Route::middleware('auth.api')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // Route::get('/chart-transactions', [DashboardController::class, 'getAllTransactions']);
    // Route::get('/chart-campaigns', [DashboardController::class, 'getCampaigns']);
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    // Route::get('/filter-data', [DashboardController::class, 'filterData']);
    
    //campaign route
    Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaign.store');
    Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaign.update');
    
    //campaign active
    Route::get('/campaignAktif', [CampaignController::class, 'campaignActive'])->name('aktif.index');
    Route::get('/campaignNonAktif', [CampaignController::class, 'campNonActive'])->name('nonaktif.index');
    Route::put('/campaign/set-active/{id}', [CampaignController::class, 'setaktif'])->name('setaktif.update');;
    Route::put('/campaign/unset-active/{id}', [CampaignController::class, 'unaktif'])->name('unaktif.update');;
    
    //campaign priority route
    Route::get('/campaign/get-priority', [PriorityController::class, 'index'])->name('priority.index');
    Route::put('/campaign/set-priority/{id}', [PriorityController::class, 'setPriority'])->name('setpriority.index');;
    Route::put('/campaign/unset-priority/{id}', [PriorityController::class, 'unsetPriority'])->name('unpriority.index');;
    
    //campaign recomendation route
    Route::get('/campaign/rekomendasi', [RecommendedController::class, 'index'])->name('recomendation.index');
    Route::put('/campaign/set-recomendation/{id}', [RecommendedController::class, 'setRecomendtion'])->name('setrecomendation.index');;
    Route::put('/campaign/unset-recomendation/{id}', [RecommendedController::class, 'unsetRecomendtion'])->name('unrecomendation.index');;
    
    //category-campaign
    Route::get('/campaign/campaign-categories', [CategoryCampaignController::class, 'index'])->name('campaignCategory.index');
    Route::post('/campaign/campaign-categories', [CategoryCampaignController::class, 'store'])->name('campaignCategory.store');
    Route::post('/campaign-categories/check', [CategoryCampaignController::class, 'checkCategory'])->name('campaignCategory.check');
    Route::put('/campaign-categories/{id}', [CategoryCampaignController::class, 'update'])->name('campaignCategory.update');
    
    //users route
    Route::get('/users', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/users/search', [PenggunaController::class, 'search'])->name('users.search');
    
    //transaksi route
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    
    //zakat route
    Route::get('/zakat', [ZakatController::class, 'index'])->name('zakat.index');
    Route::post('/zakat/check', [ZakatController::class, 'checkCategory'])->name('zakat.check');
    Route::post('/zakat', [ZakatController::class, 'store'])->name('zakat.store');
    Route::put('/zakat/{id}', [ZakatController::class, 'update'])->name('zakat.update');
    
    //infak route
    Route::get('/infak', [InfakController::class, 'index'])->name('infak.index');
    Route::post('/infak/check', [InfakController::class, 'checkCategory'])->name('infak.check');
    Route::post('/infak', [InfakController::class, 'store'])->name('infak.store');
    Route::put('/infak/{id}', [InfakController::class, 'update'])->name('infak.update');
    
    //kabarterbaru route
    Route::get('/latestNews', [KabarTerbaruController::class, 'index'])->name('news.index');
    Route::put('/latestNews/campaign/{id}', [KabarTerbaruController::class, 'update'])->name('news.update');
    Route::delete('/latestNews/delete/{id}', [KabarTerbaruController::class, 'destroy'])->name('news.destroy');
    Route::get('/latestNews/campaign', [CampaignNewsController::class, 'index'])->name('newscampaign.index');
    Route::post('/latestNews/campaign/{id}', [CampaignNewsController::class, 'setNews'])->name('newsCampaign.setNews');

    //reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/upload-reports', [ReportsController::class, 'store'])->name('reports.store');

     //reports
     Route::get('/billings', [TagihanController::class, 'index'])->name('tagihan.index');
});