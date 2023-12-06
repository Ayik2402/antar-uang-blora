<?php

use App\Http\Controllers\DaftarpermohonanTransferController;
use App\Http\Controllers\Web\BiayatransferController;
use App\Http\Controllers\Web\DaftarBankController;
use App\Http\Controllers\Web\DaftarPulsaController;
use App\Http\Controllers\Web\DaftarRekeningBankController;
use App\Http\Controllers\Web\JenistabunganController;
use App\Http\Controllers\Web\MutasirekeningController;
use App\Http\Controllers\Web\PengajuantransferController;
use App\Http\Controllers\Web\RegisternasabahController;
use App\Http\Controllers\Web\SaldaoNasabahController;
use App\Http\Controllers\Web\SettingwebController;
use App\Http\Controllers\Web\TokenListrikController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::resource('daftar-bank', DaftarBankController::class);
    Route::resource('daftar-rekening', DaftarRekeningBankController::class);
    Route::resource('biaya-transfer', BiayatransferController::class);
    Route::post('/importfiledaftarbank', [DaftarBankController::class, 'importfiledaftarbank']);
    Route::resource('jenis-tabungan', JenistabunganController::class);
    Route::resource('register-nasabah', RegisternasabahController::class);
    Route::resource('saldo', SaldaoNasabahController::class);
    Route::post('/saldoimport', [SaldaoNasabahController::class, 'import']);
    Route::get('/getjenistabungan', [JenistabunganController::class, 'getjenistabungan']);
    Route::get('/sendemail/{id}', [RegisternasabahController::class, 'kirimemailsekarang']);
    Route::get('/wastat', function () {
        return view('pages.wastat.wastat');
    });
    Route::resource('mutasi-rekening', MutasirekeningController::class);
    Route::post('/hapussemuamutasi', [MutasirekeningController::class, 'hapussemuamutasi']);
    Route::get('/data-transfer', [PengajuantransferController::class, 'datapengajuantramsfer']);
    Route::post('/updatetransaksi', [PengajuantransferController::class, 'updatetransaksinasabah']);
    Route::get('/wasrvstat', [App\Http\Controllers\HomeController::class, 'wasrvstat']);
    Route::get('/statcheck', [App\Http\Controllers\HomeController::class, 'getwacntstat']);
    Route::get('/sendmsg', [App\Http\Controllers\HomeController::class, 'sendmessage']);
    Route::get('/linechart', [App\Http\Controllers\HomeController::class, 'chattlinedashboard']);
});
