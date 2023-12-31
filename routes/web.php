<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSeatController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\WaitersController;
use App\Http\Controllers\WaitersSeatController;
use App\Http\Controllers\WaitersMenuController;
use App\Http\Controllers\WaitersOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*=========== USER START =============*/
// NAVBAR BUTTON logout
Route::get('/user/logout', [CustomerController::class,'customerLogout'])->name('customerLogout');           //route logout pada navbar customer dan akan meredirect ke form login

//landing page
Route::get('/', [Controller::class,'landing'])->name('landing');                                            //route landing page

// tampil pilihan tempat duduk
Route::get('/user/tempatDuduk', [SeatController::class,'formTmptDuduk'])->name('tmptDuduk');                //route tempat duduk

// login
Route::get('/user/signIn', [LoginController::class,'signIn'])->name('signIn');                              //route menampilkan form sign in
Route::post('/user/signIn', [LoginController::class,'signInSubmit'])->name('submit.signIn');                //route melakukan proses login saat menekan tombol
Route::get('/user/register', [LoginController::class,'register'])->name('register');                        //route menampilkan form register
Route::post('/user/register', [LoginController::class,'submitDataRegister'])->name('submit.register');        //submit form register

// submit form tempat duduk
Route::post('/user/tempatDuduk', [SeatController::class,'submitTmptDuduk'])->name('submit.tempatDuduk');              //route ketika menekan submit data tempat duduk

// Menu
Route::get('/user/menu', [MenuController::class,'menu'])->name('menu');                                     //route menampilkan view menu
Route::post('/user/menu', [MenuController::class,'submitMenu'])->name('submit.menu');                       //route ketika menekan tombol checkout pada menu

// tampilkan view invoice
Route::get('/user/invoice/{id}', [OrderController::class,'showInvoice'])->name('invoice');                               //submit/checkout form menu dan menampilkan invoice

// route pembayaran
Route::post('/testPayment', [OrderController::class, 'checkout'])->name('check');
Route::post('/utils/midtrans', [OrderController::class, 'midtransNotification']);

// Validation
Route::get('/user/validation/{status}', [TransactionController::class, 'validationStatus'])->name('validation');
/*=========== USER END =============*/



/* ADMIN */

/* ============ ADMIN LOGIN START ================== */
// Login Page
Route::get('/admin/signIn', [AdminController::class,'adminSignIn'])->name('adminSignIn');                   //route menampilkan form sign in untuk admin

// Submit Login dan tampilkan form berhasil login
Route::post('/admin/signIn', [AdminController::class,'adminSignInPost'])->name('signInPost');               //route untuk tombol submit login dan cek session

// Logout dari tampilan admin
Route::get('/admin/logout', [AdminController::class,'adminLogout'])->name('adminLogout');
/* ============ ADMIN LOGIN END ================== */


// Menampilkan tabel Reservasi
Route::get('/admin/daftarOrder', [AdminOrderController::class,'showOrderAdmin'])->name('showOrderAdmin');                                                  //route menampilkan Tabel Daftar Reservasi
Route::get('/admin/daftarOrder/cari', [AdminOrderController::class,'searchOrder'])->name('searchOrder');                                    //route menampilkan Tabel Tempat Duduk untuk Admin
Route::get('/admin/daftarOrder/{orderId}', [AdminOrderController::class,'detailOrder'])->name('detailOrder');                   //route menghapus data seat dari database
Route::put('/admin/daftarOrder/updStatus', [AdminOrderController::class,'changeStatusOrder'])->name('changeStatusOrder');                   //route menghapus data seat dari database


/* ============= ADMIN SEAT START =================== */
// Menampilkan tabel Tempat duduk
Route::get('/admin/daftarTempatDuduk', [AdminSeatController::class,'showTmptDudukAdmin'])->name('showTmptDudukAdmin');                                    //route menampilkan Tabel Tempat Duduk untuk Admin

// Fitur Pencarian Pada View Tempat Duduk
Route::get('/admin/daftarTempatDuduk/cari', [AdminSeatController::class,'searchSeat'])->name('searchSeat');                                    //route menampilkan Tabel Tempat Duduk untuk Admin

// CRUD SEAT
Route::post('/admin/daftarTempatDuduk', [AdminSeatController::class,'storeSeat'])->name('addSeat');                                             //route menambahkan data tempat duduk baru ke database
Route::put('/admin/daftarTempatDuduk/{seatId}', [AdminSeatController::class,'updateStatusSeat'])->name('updateStatusSeatAdmin');                   //route menambahkan data tempat duduk baru ke database
Route::put('/admin/daftarTempatDuduk', [AdminSeatController::class,'editSeat'])->name('editSeatAdmin');                             //route edit data seat
Route::delete('/admin/daftarTempatDuduk/{seatId}', [AdminSeatController::class,'deleteSeat'])->name('deleteSeatAdmin');                   //route menghapus data seat dari database
/* ============= ADMIN SEAT END =================== */


/* ============= ADMIN MENU START ==================*/
// Menampilkan tabel Makanan
Route::get('/admin/makanan', [AdminMenuController::class,'showMakananAdmin'])->name('showMakananAdmin');                      //route menampilkan tabel makanan

// Menampilkan tabel Minuman
Route::get('/admin/minuman', [AdminMenuController::class,'showMinumanAdmin'])->name('showMinumanAdmin');                      //route menampilkan tabel minuman

// Search Menu
Route::get('/admin/menu/{kategori}', [AdminMenuController::class,'searchMenu'])->name('searchMenuAdmin');                   //route menghapus data seat dari database

// CRUD MENU
Route::post('/admin/menu/{kategori}', [AdminMenuController::class,'addMenu'])->name('addMenuAdmin');                   //route menghapus data seat dari database
Route::delete('/admin/menu/{menuId}', [AdminMenuController::class,'deleteMenu'])->name('deleteMenuAdmin');                   //route menghapus data seat dari database
Route::put('/admin/menu/{kategori}', [AdminMenuController::class,'editMenu'])->name('editMenuAdmin');                   //route menghapus data seat dari database
/* ============= ADMIN MENU END ==================*/






Route::get('/waiters/signIn', [WaitersController::class,'waitersSignIn'])->name('waitersSignIn');                   //route menampilkan form sign in untuk admin

// Submit Login dan tampilkan form berhasil login
Route::post('/waiters/signIn', [WaitersController::class,'waitersSignInPost'])->name('waitersInPost');               //route untuk tombol submit login dan cek session

// Logout dari tampilan admin
Route::get('/waiters/logout', [WaitersController::class,'waitersLogout'])->name('waitersLogout');

Route::get('/waiters/daftarOrder', [WaitersOrderController::class,'showOrderWaiters'])->name('showOrderWaiters');                                                  //route menampilkan Tabel Daftar Reservasi
Route::get('/waiters/daftarOrder/cari', [WaitersOrderController::class,'searchOrder'])->name('searchOrder');                                    //route menampilkan Tabel Tempat Duduk untuk Admin
Route::get('/waiters/daftarOrder/{orderId}', [WaitersOrderController::class,'detailOrder'])->name('detailOrder');                   //route menghapus data seat dari database
Route::put('/waiters/daftarOrder/updStatus', [WaitersOrderController::class,'changeStatusOrder'])->name('changeStatusOrder');

/* ============= ADMIN SEAT START =================== */
// Menampilkan tabel Tempat duduk
Route::get('/waiters/daftarTempatDuduk', [WaitersSeatController::class,'showTmptDudukWaiters'])->name('showTmptDudukWaiters');                                    //route menampilkan Tabel Tempat Duduk untuk Admin

// Fitur Pencarian Pada View Tempat Duduk
Route::get('/waiters/daftarTempatDuduk/cari', [WaitersSeatController::class,'searchSeat'])->name('searchSeat');  

Route::get('/waiters/makanan', [WaitersMenuController::class,'showMakanan'])->name('showMakanan');  

// Menampilkan tabel Minuman
Route::get('/waiters/minuman', [WaitersMenuController::class,'showMinuman'])->name('showMinuman');                      //route menampilkan tabel minuman

// Search Menu
Route::get('/waiters/menu/{kategori}', [WaitersMenuController::class,'searchMenu'])->name('searchMenu');   

