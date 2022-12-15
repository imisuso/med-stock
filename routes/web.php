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
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AnnouceController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CheckInOrderController;
use App\Http\Controllers\CheckInOrderPurchaseController;
use App\Http\Controllers\ItemTransactionController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintFormController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\StockItemImportController;
use App\Http\Controllers\UserController;
use App\Models\Agreement;
use App\Models\Annouce;
use Illuminate\Support\Facades\Storage;

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

//  Route::get('/welcome', function () {
//    return view('welcome');
//  });

Route::get('/dashboard', function () {
   // return view('dashboard');
    return Inertia('Dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/login-test', function () {
    // return view('welcome');
    return Inertia('Auth/Login');
   
});
    

Route::get('/', function () {
    // return view('welcome');
    //return Inertia('Auth/Login');
  //  $doc_division_filename = 'poster_teacher_ios.pdf';

    $doc_division_filename = Storage::url('docs/poster_division_med_stock.pdf');
    $annouces = Annouce::where(['status'=>'on','show_on_page'=>'login'])
                         ->get();
    //logger($annouces);
   // dd($doc_division);
    return Inertia::render('Auth/LoginAD',[
                             'annouces'=>$annouces,
                         ],
                         compact('doc_division_filename')
                    );

})->name('welcome');

Route::post('/login',[LoginController::class, 'authenticate'])->name('login')->middleware('guest');
    
Route::get('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');

//แสดงหน้าเบิกวัสดุ
Route::get('/stock', [StockController::class,'index'])->name('stock')->middleware('auth','can:checkout_item');
//Route::post('/stock/item-filter', [StockController::class,'filter'])->name('stock-item-filter')->middleware('auth','can:checkout_item');

Route::controller(ItemTransactionController::class)
        ->middleware('auth')
        ->group(function(){
            //แสดงรายละเอียดการเบิก/ตรวจรับ วัสดุ
            Route::get('/stock-item/{stock_item}','show')->name('list-stock-item'); 
            //เบิกวัสดุ
            Route::post('/checkout-stock-item','store')->name('checkout-stock-item');
            //ยกเลิกรายการเบิกวัสดุ
            Route::post('/cancel-checkout-stock-item','destroy')->name('cancel-checkout-stock-item');
            //ยกเลิกรายการนำเข้าวัสดุ
            Route::post('/cancel-checkin-stock-item','cancelCheckin')->name('cancel-checkin-stock-item');
        });
//แสดงรายละเอียดการเบิก/ตรวจรับ วัสดุ
//Route::get('/stock-item/{stock_item}', [ItemTransactionController::class,'show'])->name('list-stock-item')->middleware('auth');
//เบิกวัสดุ
//Route::post('/checkout-stock-item', [ItemTransactionController::class,'store'])->name('checkout-stock-item')->middleware('auth');


//ไม่แน่ใจว่าจะใช้ หน้าแสดงข้อมูลปีเดือน ที่มีการเบิกวัสดุ
//Route::get('/report-stock/{division_id}', [ReportStockController::class,'show'])->name('report-stock')->middleware('auth');
//ไม่แน่ใจว่าจะใช้ หน้าแสดงรายละเอียดการเบิกวัสดุ
Route::get('/report-checkout-item/{division_id}', [ReportStockController::class,'index'])->name('report-checkout-item')->middleware('auth','can:view_master_data');
Route::get('/get-checkout-item/{stock_id}/{year}/{month}', [ReportStockController::class,'show'])->name('get-checkout-item')->middleware('auth');
Route::get('/export-checkout-item/{stock_id}/{year}/{month}', [ReportStockController::class,'export'])->name('export-checkout-item')->middleware('auth');
Route::get('/export-checkout-item-test/{checkout_items}', [ReportStockController::class,'export_test'])->name('export-checkout-item-test')->middleware('auth');
Route::get('/print-cutstock/pdf/{stock_id}/{year}/{month}', [PrintFormController::class,'printCutStock'])->name('print-cutstock-pdf')->middleware('auth');


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
//บันทึกรับวัสดุใหม่ลงคลัง
Route::post('/order-list/checkin/', [CheckInOrderController::class,'store'])->name('checkin-order')->middleware('auth');
//แสดงหน้าตรวจรับวัสดุ
    Route::get('/receive-order/{order}', [CheckInOrderController::class,'update'])->name('receive-order')->middleware('auth');
//พิมพ์ใบตรวจรับ
Route::get('/create-order/print-checkin/{order}', [PrintFormController::class,'create'])->name('print-checkin')->middleware('auth');
//ดูจำนวนคงเหลือหลังตรวจรับ
Route::get('/order-list/show/{order_id}', [CheckInOrderController::class,'show'])->name('view-checkin-order')->middleware('auth');

//Route::get('/admin/report-list/{division_id}', [AdminReportStockController::class,'index'])->name('report-list')->middleware('auth');
Route::match(['get', 'post'],'/admin/report-list/{division_id}',[AdminReportStockController::class,'index'])->name('report-list')->middleware('auth');
Route::post('/admin/report-stock', [AdminReportStockController::class,'show'])->name('admin-report-stock')->middleware('auth','can:view_master_data');

//แสดงรายการใบสั่งซื้อแบบสัญญา
Route::get('/admin/order-list/', [AdminOrderController::class,'index'])->name('check-order-list')->middleware('auth','can:manage_master_data');
//อนุมัติใบสั่งซื้อ
Route::post('/admin/order-list/update', [AdminOrderController::class,'update'])->name('approve-order')->middleware('auth','can:manage_master_data');

//แสดงหน้าแรก ค้นหาข้อมูลงบประมาณในแต่ละปี
Route::get('/admin/budget-list/', [BudgetController::class,'index'])->name('budget-list')->middleware('auth','can:view_master_data');
//ดึงรายการงบประมาณตั้งต้นแต่ละสาขา ตามปีที่ระบุ
Route::get('/admin/get-list-budget', [BudgetController::class,'show'])->name('get-list-budget')->middleware('auth','can:view_master_data')->middleware('remember');
//บันทึกงบประมาณสาขา
Route::post('/admin/add-budget',[BudgetController::class,'store'])->name('add-budget')->middleware('auth','can:manage_master_data');
//แก้ไขข้อมูลงบ
Route::post('/admin/edit-budget',[BudgetController::class,'edit'])->name('edit-budget')->middleware('auth','can:manage_master_data');
//พิมพ์งบประมาณคงเหลือและใบสั่งซื้อ
Route::get('/admin/print-budget-order/{stock_id}/{year}', [PrintFormController::class,'printBudgetOrder'])->name('print-budget-order')->middleware('auth','can:view_master_data');
//แสดงงบประมาณในรายการสั่งซื้อแต่ละครั้ง
Route::get('/admin/get-list-order/{stock_id}/{year}', [ItemTransactionController::class,'index'])->name('get-list-order')->middleware(['auth','can:view_master_data','remember']);
//พิมพ์งบประมาณคงเหลือและใบสั่งซื้อ
Route::get('/admin/print-budget-order-import/{stock_id}/{year}', [PrintFormController::class,'printBudgetOrderImport'])->name('print-budget-order-import')->middleware('auth','can:view_master_data');
//ดึงรายรายละเอียดการสั่งซื้อ ตามเลข Pur.Order
Route::post('/admin/get-list-budget-detail', [ItemTransactionController::class,'edit'])->name('get-list-budget-detail')->middleware('auth','can:view_master_data');

Route::controller(AdminOrderPurchaseController::class)
        ->middleware('auth','can:manage_master_data')
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

//แสดงหน้าตรวจรับวัสดุ จากใบสั่งซื้อ
Route::get('/receive-order-purchase/{order}', [CheckInOrderPurchaseController::class,'show'])->name('receive-order-purchase')->middleware('auth');

//ค้นหาวัสดุ
Route::get('/search-stock-item/{item_name_search}', [StockItemController::class,'searchByItemName'])->name('search-stock-item')->middleware('auth');
//printForm test
Route::get('/testprint', [PrintFormController::class,'index'])->name('testprint');

//Import Data From Excel
Route::get('/stockitem/import',[StockItemImportController::class,'index'])->name('stock-item-import')->middleware('auth')->middleware('remember');

Route::post('/stockitem/import',[StockItemImportController::class,'show'])->name('stock-item-import-show')->middleware('auth');

Route::post('/stockitem/checkin-to-stock',[StockItemImportController::class,'store'])->name('import-checkin-to-stock')->middleware('auth');

//Add User
Route::get('/user/add',[UserController::class,'index'])->name('user-add')->middleware('auth')->middleware('remember');
Route::get('/user/check-employee-status/{sap_id}',[UserController::class,'checkEmployeeStatus'])->name('check-employee-status')->middleware('auth');
Route::post('/user/add',[UserController::class,'store'])->name('add-user')->middleware('auth');
//show detail user for edit
Route::get('/user/show-detail-user/{slug}',[UserController::class,'edit'])->name('show-detail-user')->middleware('auth');
//update stock 
Route::post('/user/update-user/{user}',[UserController::class,'update'])->name('update-user')->middleware('auth');


//Add Stock
Route::get('/stock/add',[StockController::class,'show'])->name('stock-add')->middleware('auth')->middleware('remember');
Route::post('/stock/add',[StockController::class,'store'])->name('stock-add-confirm')->middleware('auth');

//**********เมนูการจัดการคลังวัสดุ 
//get-list-stock-unit
Route::get('/stock/get-list-stock-unit/{unit_id}',[StockController::class,'getListStockUnit'])->name('get-list-stock-unit')->middleware('auth');
//show detail stock for edit
Route::get('/stock/show-detail-stock/{stock}',[StockController::class,'edit'])->name('show-detail-stock')->middleware('auth');
//update stock 
Route::post('/stock/update-stock/{stock}',[StockController::class,'update'])->name('update-stock')->middleware('auth');

//Log
Route::get('/stock/show-log/{slug}',[LogActivityController::class,'show'])->name('show-log')->middleware('auth','can:manage_master_data');
Route::get('/stock/index-get-log/',[LogActivityController::class,'index'])->name('index-get-log')->middleware('auth','can:manage_master_data');
Route::match(['get', 'post'],'/stock/get-log/',[LogActivityController::class,'index'])->name('get-log')->middleware('auth','can:manage_master_data');
//annouce
Route::get('/add-annouce',[AnnouceController::class,'index'])->name('add-annouce')->middleware('auth','can:manage_master_data');
Route::post('/add-annouce',[AnnouceController::class,'index'])->name('add-annouce-new')->middleware('auth','can:manage_master_data');
Route::get('/annouce',[AnnouceController::class,'show'])->name('annouce')->middleware('auth');

Route::post('/update_status-annouce',[AnnouceController::class,'update'])->name('update_status-annouce')->middleware('auth');
//Route::post('/close-annouce',[AnnouceController::class,'update'])->name('close-annouce')->middleware('auth');
//Route::post('/open-annouce',[AnnouceController::class,'update'])->name('open-annouce')->middleware('auth');
Route::post('/delete-annouce',[AnnouceController::class,'update'])->name('delete-annouce')->middleware('auth');


/* Feature Agreements Users */
// Route::get('/agreement',function(){
//     return Inertia('Agreement',[
//                     'agreements'=> Agreement::OrderByDesc('date_effected')->first()
//     ]);

// })->middleware('auth')->name('agreement');
Route::get('/agreement',[AgreementController::class, 'index'])->middleware('auth')->name('agreement');

Route::post('accept-agreement', [AgreementController::class, 'store'])->middleware('auth')->name('accept-agreement');

Route::get('/nong', function () {
    return view('welcome');
    //return view('stock.StockItemImport');
  });