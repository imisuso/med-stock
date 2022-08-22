<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;
use App\Http\Controllers\StockController;
//use App\Http\Controllers\StockItemController;
use App\Http\Controllers\ReportStockController;
use App\Http\Controllers\CreateOrderController;
use App\Http\Controllers\AdminReportStockController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminOrderPurchaseController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CheckInOrderController;
use App\Http\Controllers\CheckInOrderPurchaseController;
use App\Http\Controllers\ItemTransactionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintFormController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\StockItemController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', function () {
    // return view('welcome');
    return Inertia('Auth/Login');
});
    
Route::get('/annouce', [LoginController::class,'index'])->name('annouce')->middleware('auth');
//แสดงหน้าเบิกพัสดุ
Route::get('/stock', [StockController::class,'index'])->name('stock')->middleware('auth','can:checkout_item');

Route::controller(ItemTransactionController::class)
        ->middleware('auth')
        ->group(function(){
            //แสดงรายละเอียดการเบิก/ตรวจรับ พัสดุ
            Route::get('/stock-item/{stock_item}','show')->name('list-stock-item'); 
            //เบิกพัสดุ
            Route::post('/checkout-stock-item','store')->name('checkout-stock-item');
        });
//แสดงรายละเอียดการเบิก/ตรวจรับ พัสดุ
//Route::get('/stock-item/{stock_item}', [ItemTransactionController::class,'show'])->name('list-stock-item')->middleware('auth');
//เบิกพัสดุ
//Route::post('/checkout-stock-item', [ItemTransactionController::class,'store'])->name('checkout-stock-item')->middleware('auth');


//ไม่แน่ใจว่าจะใช้ หน้าแสดงข้อมูลปีเดือน ที่มีการเบิกพัสดุ
//Route::get('/report-stock/{division_id}', [ReportStockController::class,'show'])->name('report-stock')->middleware('auth');
//ไม่แน่ใจว่าจะใช้ หน้าแสดงรายละเอียดการเบิกพัสดุ
Route::get('/report-checkout-item/{division_id}', [ReportStockController::class,'index'])->name('report-checkout-item')->middleware('auth','can:manage_master_data');
Route::get('/get-checkout-item/{stock_id}/{year}/{month}', [ReportStockController::class,'show'])->name('get-checkout-item')->middleware('auth');


//หน้าแรกสร้างใบสั่งซื้อแบบสัญญา
Route::get('/create-order', [CreateOrderController::class,'index'])->name('create-order')->middleware('auth');
//สร้างใบสั่งซื้อแบบสัญญา
Route::post('/create-order/add', [CreateOrderController::class,'store'])->name('add-order')->middleware('auth');
//พิมพ์ใบสั่งซื้อแบบสัญญา
Route::get('/create-order/print/{order}', [PrintFormController::class,'show'])->name('print-order')->middleware('auth');
//แสดงรายการสร้างเอกสารใบสั่งซื้อแบบสัญญา
Route::get('/order-list', [CreateOrderController::class,'show'])->name('order-list')->middleware('auth');
//ส่งเอกสารใบสั่งซื้อแบบสัญญา
Route::post('/order-list/update', [CreateOrderController::class,'update'])->name('send-order')->middleware('auth');
//บันทึกรับพัสดุใหม่ลงคลัง
Route::post('/order-list/checkin/', [CheckInOrderController::class,'store'])->name('checkin-order')->middleware('auth');
//แสดงหน้าตรวจรับพัสดุ
    Route::get('/receive-order/{order}', [CheckInOrderController::class,'update'])->name('receive-order')->middleware('auth');
//พิมพ์ใบตรวจรับ
Route::get('/create-order/print-checkin/{order}', [PrintFormController::class,'create'])->name('print-checkin')->middleware('auth');
//ดูจำนวนคงเหลือหลังตรวจรับ
Route::get('/order-list/show/{order_id}', [CheckInOrderController::class,'show'])->name('view-checkin-order')->middleware('auth');

Route::get('/admin/report-list/{division_id}', [AdminReportStockController::class,'index'])->name('report-list')->middleware('auth');
Route::get('/admin/report-stock/{stock_slug}', [AdminReportStockController::class,'show'])->name('admin-report-stock')->middleware('auth');

//แสดงรายการใบสั่งซื้อแบบสัญญา
Route::get('/admin/order-list/', [AdminOrderController::class,'index'])->name('check-order-list')->middleware('auth');
//อนุมัติใบสั่งซื้อ
Route::post('/admin/order-list/update', [AdminOrderController::class,'update'])->name('approve-order')->middleware('auth');

//แสดงหน้าแรก ค้นหาข้อมูลงบประมาณในแต่ละปี
Route::get('/admin/budget-list/', [BudgetController::class,'index'])->name('budget-list')->middleware('auth','can:manage_master_data');
//ดึงรายการงบประมาณตั้งต้นแต่ละสาขา ตามปีที่ระบุ
Route::get('/admin/get-list-budget/{year}', [BudgetController::class,'show'])->name('get-list-budget')->middleware('auth','can:manage_master_data');
//บันทึกงบประมาณสาขา
Route::post('/admin/add-budget',[BudgetController::class,'store'])->name('add-budget')->middleware('auth','can:manage_master_data');
//แก้ไขข้อมูลงบ
Route::post('/admin/edit-budget',[BudgetController::class,'edit'])->name('edit-budget')->middleware('auth','can:manage_master_data');
//พิมพ์งบประมาณคงเหลือและใบสั่งซื้อ
Route::get('/admin/print-budget-order/{stock_id}/{year}', [PrintFormController::class,'printBudgetOrder'])->name('print-budget-order')->middleware('auth','can:manage_master_data');


Route::controller(AdminOrderPurchaseController::class)
        ->middleware('auth')
        ->group(function(){
            //หน้าแรกบันทึกใบสั่งซื้อเก่า
            Route::get('/admin/add-order-purchase/','index')->name('add-order-purchase'); 
            //หน้าแรกบันทึกใบสั่งซื้อเก่า
            Route::get('/create-order-purchase/','index')->name('create-order-purchase'); 
            //บันทึกใบสั่งซื้อ
            Route::post('/admin/store-purchase/','store')->name('store-purchase');
            //ดึงข้อมูลใบสั่งซื้อมาแก้ไข
            Route::post('/edit-order-purchase/','edit')->name('get-edit-order-purchase'); 
            //แก้ไขข้อมูลใบสั่งซื้อ
            Route::post('/update-order-purchase/','update')->name('edit-purchase'); 
        });
//หน้าแรกบันทึกใบสั่งซื้อเก่า
//Route::get('/admin/add-order-purchase/', [AdminOrderPurchaseController::class,'index'])->name('add-order-purchase')->middleware('auth','can:manage_master_data');

Route::controller(PurchaseOrderController::class)
        ->middleware('auth')
        ->group(function(){
            //หน้าแรกค้นหาใบสั่งซื้อ ตามปีงบ
            Route::match(['get', 'post'],'/purchase-order-list/','index')->name('purchase-order-list');
            //ค้นหาใบสั่งซื้อ ตามปีงบ
            Route::get('/get-purchase-order/{year}','show')->name('get-purchase-order');
            //ส่งใบสั่งซื้อ
            Route::post('/send-order-purchase/{order}','update')->name('send-order-purchase');
            //admin อนุมัติใบสั่งซื้อ
            Route::post('/approve-order-purchase/{order}','update')->name('approve-order-purchase');
        });

//พิมพ์ใบสั่งซื้อ
Route::get('/purchase-order/print/{order}', [PrintFormController::class,'printPurchaseOrder'])->name('print-purchase-order')->middleware('auth');
Route::get('/purchase-order/print-item/{order}', [PrintFormController::class,'printPurchaseOrderItem'])->name('print-purchase-order-item')->middleware('auth');

//แสดงหน้าตรวจรับพัสดุ จากใบสั่งซื้อ
Route::get('/receive-order-purchase/{order}', [CheckInOrderPurchaseController::class,'show'])->name('receive-order-purchase')->middleware('auth');

//ค้นหาพัสดุ
Route::get('/search-stock-item/{item_name_search}', [StockItemController::class,'searchByItemName'])->name('search-stock-item')->middleware('auth');
//printForm test
Route::get('/testprint', [PrintFormController::class,'index'])->name('testprint');