<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FuelDebtController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TruckLocationController;
use App\Http\Controllers\OrganizationController;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsStaff;
use App\Models\User;


Route::get('/', function () {
    
    if (auth()->id()) {
        $user = User::find(auth()->id());
        $role = $user->role_id;
        
        switch ($role) {
            case 1:
                return redirect()->route('dashboard');
            case 2:
                return redirect()->route('staff_dashboard');
            default:
                return redirect()->route('login'); // Or some other default route
        }
    } else {
        return view('auth.login');
    }
})->name('home');


Route::middleware(['auth',IsAdmin::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/activity-logs', [AdminController::class, 'getActivityLogs'])->name('activityLogss');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/active',[UserController::class,'active'])->name('users.active');
    Route::get('/users/inactive',[UserController::class,'inactive'])->name('users.inactive');
    Route::get('/users/{id}/status', [UserController::class, 'changeuserStatus'])->name('userstatus');
    Route::get('/users/{id}/edit', [UserController::class, 'edituser'])->name('edit');
    Route::put('/users/{id}/', [UserController::class, 'updateuser'])->name('updateuser');
    Route::get('/users/{id}/role_edit',[UserController::class,'role_edit'])->name('users.redit');
    Route::get('/users/{id}/password_edit',[UserController::class,'password_edit'])->name('users.pedit');
    Route::get('/users/create', [UserController::class, 'createuser'])->name('createuser');
    Route::post('/users/create', [UserController::class, 'storeuser'])->name('storeuser');
    Route::get('/users/{id}/deactivate',[UserController::class,'deactivate'])->name('users.deactivate');
    Route::get('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::put('/users/{id}/password_update',[UserController::class, 'password_update'])->name('users.pupdate');


    Route::resource('admin-clients',ClientController::class)->except([
        'destroy'
    ]);
    //Route::get('/clients/pdf','ClientController@indexpdf')->name('clients.indexpdf');
    //Route::get('admin/clients', [ClientController::class, 'index'])->name('clients');
    //Route::resource('expenses', ExpensesController::class);
    Route::resource('admin-trucks', TruckController::class)->except([
        'destroy'
    ]);
    Route::resource('admin-drivers',DriversController::class)->except([
        'destroy'
    ]);
    Route::get('/admin-drivers/tasks/{id}', [DriversController::class,'driverTasks'] )->name('admin-drivers.tasks');
    Route::get('/admin-drivers/tasks/{id}/details',[DriversController::class,'taskdetails'] )->name('admin-drivers.taskdetails');
    Route::get('/admin-drivers/tasks/{id}/pdf',[DriversController::class, 'taskdetailspdf'] )->name('admin-drivers.taskdetailspdf');
    Route::get('/admin-drivers/tasks/{id}/taskcomplete',[DriversController::class, 'taskcomplete'] )->name('admin-drivers.taskcomplete');


   
   
    Route::resource('admin-goods',GoodController::class)->except([
        'destroy'
    ]);
    Route::post('/admin-goods/create/TruckfetchDriver',[GoodController::class,'TruckfetchDriver'])->name('admin-good.TruckfetchDriver');
    Route::get('admin-goods/{id}/dedit',[GoodController::class,'goodDelivered'])->name('admin-goods.dedit');

    Route::resource('admin-payments',PaymentController::class)->except([
        'destroy'
    ]);

    Route::resource('admin-expenses', ExpensesController::class)->except([
        'destroy'
    ]);

    Route::resource('admin-fuelDebt', FuelDebtController::class)->except([
        'destroy'
    ]);
    Route::get('/admin-fuelDebt/{id}/pdf',[FuelDebtController::class, 'indexpdf'])->name('admin-fuelDebt.indexpdf');
    Route::get('/admin-fuelDebt/{id}/ppdf',[FuelDebtController::class, 'indexppdf'])->name('admin-fuelDebt.indexppdf');
    Route::get('fuelDebt/{id}/cdebt',[FuelDebtController::class, 'cdebt'])->name('fuelDebt.cdebt');
    Route::get('fuelDebt/{id}/payment',[FuelDebtController::class, 'payment'])->name('fuelDebt.payment');
    Route::post('fuelDebt/store_payment',[FuelDebtController::class, 'store_payment'])->name('fuelDebt.pstore');


    Route::get('admin-stocks/stocktypecreate', [StockController::class, 'stocktypecreate'])->name('admin-stocks.typecreate');
    Route::post('admin-stocks/stocktypecreate',[StockController::class, 'storetype'])->name('admin-stocks.storetype');

    
    Route::resource('admin-stocks', StockController::class)->except(['destroy']);
    Route::get('admin-stocks/{id}/assign', [StockController::class, 'assignGood'])->name('admin-stocks.assignGood');
    Route::post('admin-stocks/{id}/assign', [StockController::class, 'assign'])->name('admin-stocks.assign.store');

    Route::get('admin-stocks/{id}/assignEdit', [StockController::class, 'assignGoodEdit'])->name('admin-stocks.assignGoodEdit');
    Route::post('admin-stocks/{id}/assignEdit', [StockController::class, 'assignUpdate'])->name('admin-stocks.assign.update');

   


    // Route::get('/drivers/apdf','DriversController@indexapdf')->name('drivers.indexapdf');
    // Route::get('/drivers/pdf','DriversController@indexpdf')->name('drivers.indexpdf');
    Route::get('/admin-clients-pdf',[ClientController::class, 'indexpdf'])->name('admin-clients.indexpdf');
    //Route::get('/trucks/pdf','TruckController@indexpdf')->name('trucks.indexpdf');
    Route::get('/admin-goods-pdf/undelivered',[GoodController::class, 'indexpdf'])->name('admin-goods.indexpdf');
    Route::get('/admin-goods-pdf/delivered',[GoodController::class, 'indexdpdf'])->name('admin-goods.indexdpdf');
     Route::get('/admin-payments-pdf/completed',[PaymentController::class,'indexcpdf'])->name('admin-payments.indexcpdf');
     Route::get('/admin-payments-pdf/uncompleted',[PaymentController::class,'indexpdf'])->name('admin-payments.indexpdf');
    Route::get('/expenses/pdf',[ExpensesController::class, 'indexpdf'])->name('expenses.indexpdf');
    
    Route::get('/admin-clients/transactions/pdf/{id}',[ClientController::class, 'transactionspdf'])->name('admin-clients.transactionspdf');
    Route::get('admin-stock/assignments/pdf', [StockController::class, 'stocks_assignPDF'])->name('admin-stocks.assignPDF');





    // Admin-only paths and names: the staff group below reuses the old /clients and /trucks ones
    Route::get('/admin-clients/transactions/{id}',[ClientController::class, 'transactions'] )->name('admin-clients.transactions');
    Route::post('/admin-clients/transactions/baupdate', [ClientController::class, 'updateBulk'])->name('admin-clients.bupdate');

    Route::get('/admin-trucks/{id}/operations',[TruckController::class, 'operations'])->name('admin-trucks.operations');
    Route::get('/admin-trucks/{id}/operationspdf',[TruckController::class, 'operationspdf'])->name('admin-trucks.operationspdf');
    Route::get('/admin-trucks/{id}/location', [TruckLocationController::class, 'admin'])->name('admin-trucks.location');

    Route::get('/admin-organization', [OrganizationController::class, 'edit'])->name('organization.edit');
    Route::put('/admin-organization', [OrganizationController::class, 'update'])->name('organization.update');

  
     

});

Route::middleware(['auth', IsStaff::class])->group(function () {


    Route::get('/Staff_dashboard', [StaffController::class, 'dashboard'])->name('staff_dashboard');
    Route::get('/Clients', [StaffController::class, 'Client_index'])->name('clients.index');
    Route::get('/clients/create', [StaffController::class, 'Client_create'])->name('clients.create');
    Route::post('/Clients/store', [StaffController::class, 'Client_store'])->name('clients.store');
    Route::get('/Clients/show', [StaffController::class, 'Client_show'])->name('clients.show');
    Route::get('/Clients/edit/{client}/', [StaffController::class, 'Client_edit'])->name('clients.edit');
    Route::put('/Clients/update/{client}/', [StaffController::class, 'Client_update'])->name('clients.update');
    Route::post('/Clients/destroy', [StaffController::class, 'Client_destroy'])->name('clients.destroy');
    Route::get('/clients/transactions/{id}',[StaffController::class, 'transactions'] )->name('clients.transactions');
    Route::post('/clients/transactions/baupdate', [StaffController::class, 'updateBulk'])->name('clients.bupdate');
    Route::get('/clients/transactions/pdf/{id}',[ClientController::class, 'transactionspdf'])->name('clients.transactionspdf');
   
    Route::get('/trucks', [StaffController::class, 'trucks_index'])->name('trucks.index');
    Route::get('/trucks/create', [StaffController::class, 'trucks_create'])->name('trucks.create');
    Route::post('/trucks/store', [StaffController::class, 'trucks_store'])->name('trucks.store');
    Route::get('/trucks/show/{truck}/', [StaffController::class, 'trucks_show'])->name('trucks.show');
    Route::get('/trucks/edit/{truck}/', [StaffController::class, 'trucks_edit'])->name('trucks.edit');
    Route::put('/trucks/update/{truck}/', [StaffController::class, 'trucks_update'])->name('trucks.update');
    Route::post('/trucks/destroy', [StaffController::class, 'trucks_destroy'])->name('trucks.destroy');
    Route::get('/trucks/operations/{id}',[StaffController::class, 'operations'])->name('trucks.operations');
    Route::get('/trucks/operationspdf/{id}',[StaffController::class, 'operationspdf'])->name('trucks.operationspdf');
    Route::get('/trucks/location/{id}', [TruckLocationController::class, 'staff'])->name('trucks.location');

    Route::get('/drivers', [StaffController::class, 'drivers_index'])->name('drivers.index');
    Route::get('/drivers/create', [StaffController::class, 'drivers_create'])->name('drivers.create');
    Route::post('/drivers/store', [StaffController::class, 'drivers_store'])->name('drivers.store');
    Route::get('/drivers/show/{driver}/', [StaffController::class, 'drivers_show'])->name('drivers.show');
    Route::get('/drivers/edit/{driver}/', [StaffController::class, 'drivers_edit'])->name('drivers.edit');
    Route::put('/drivers/update/{driver}/', [StaffController::class, 'drivers_update'])->name('drivers.update');
    Route::post('/drivers/destroy', [StaffController::class, 'drivers_destroy'])->name('drivers.destroy');
    Route::get('/drivers/tasks/{id}', [StaffController::class,'driverTasks'] )->name('drivers.tasks');
    Route::get('/drivers/tasks/{id}/details',[StaffController::class,'taskdetails'] )->name('drivers.taskdetails');
    Route::get('/driver/tasks/{id}/pdf',[StaffController::class, 'taskdetailspdf'] )->name('drivers.taskdetailspdf');
    Route::get('/drivers/tasks/{id}/taskcomplete',[StaffController::class, 'taskcomplete'] )->name('drivers.taskcomplete');

    Route::get('/goods', [StaffController::class, 'goods_index'])->name('goods.index');
    Route::get('/goods/create', [StaffController::class, 'goods_create'])->name('goods.create');
    Route::post('/goods/store', [StaffController::class, 'goods_store'])->name('goods.store');
    Route::get('/goods/show/{goods}/', [StaffController::class, 'goods_show'])->name('goods.show');
    Route::get('/goods/edit/{good}/', [StaffController::class, 'goods_edit'])->name('goods.edit');
    Route::put('/goods/update/{good}/', [StaffController::class, 'goods_update'])->name('goods.update');
    Route::post('/goods/destroy', [StaffController::class, 'goods_destroy'])->name('goods.destroy');
    Route::post('/goods/create/TruckfetchDriver',[StaffController::class,'TruckfetchDriver'])->name('good.TruckfetchDriver');
    Route::get('goods/{id}/dedit',[StaffController::class,'goodDelivered'])->name('goods.dedit');
    Route::get('/goods/pdf',[StaffController::class, 'goods_indexpdf'])->name('goods.indexpdf');
    Route::get('/goods/dpdf',[StaffController::class, 'goods_indexdpdf'])->name('goods.indexdpdf');
   
    Route::get('/payments', [StaffController::class, 'payments_index'])->name('payments.index');
    Route::get('/payments/create', [StaffController::class, 'payments_create'])->name('payments.create');
    Route::post('/payments/store', [StaffController::class, 'payments_store'])->name('payments.store');
    Route::get('/payments/show/{payment}/', [StaffController::class, 'payments_show'])->name('payments.show');
    Route::get('/payments/edit/{payment}/', [StaffController::class, 'payments_edit'])->name('payments.edit');
    Route::put('/payments/update/{payment}/', [StaffController::class, 'payments_update'])->name('payments.update');
    Route::post('/payments/destroy', [StaffController::class, 'payments_destroy'])->name('payments.destroy');


    Route::get('/expenses', [StaffController::class, 'expenses_index'])->name('expenses.index');
    Route::get('/expenses/create', [StaffController::class, 'expenses_create'])->name('expenses.create');
    Route::post('/expenses/store', [StaffController::class, 'expenses_store'])->name('expenses.store');
    Route::get('/expenses/show/{expense}/', [StaffController::class, 'expenses_show'])->name('expenses.show');
    Route::get('/expenses/edit/{expense}/', [StaffController::class, 'expenses_edit'])->name('expenses.edit');
    Route::put('/expenses/update/{expense}/', [StaffController::class, 'expenses_update'])->name('expenses.update');
    Route::post('/expenses/destroy', [StaffController::class, 'expenses_destroy'])->name('expenses.destroy');
    Route::get('/expense/pdf',[StaffController::class, 'expenses_indexpdf'])->name('expense.indexpdf');
   

    Route::get('/fuelDebts', [StaffController::class, 'fuelDebt_index'])->name('fuelDebts.index');
    Route::get('/fuelDebts/create', [StaffController::class, 'fuelDebt_create'])->name('fuelDebts.create');
    Route::post('/fuelDebts/store', [StaffController::class, 'fuelDebt_store'])->name('fuelDebts.store');
    Route::get('/fuelDebts/show/{expense}/', [StaffController::class, 'fuelDebt_show'])->name('fuelDebts.show');
    Route::get('/fuelDebts/edit/{expense}/', [StaffController::class, 'fuelDebt_edit'])->name('fuelDebts.edit');
    Route::put('/fuelDebts/update/{expense}/', [StaffController::class, 'fuelDebt_update'])->name('fuelDebts.update');
    Route::post('/fuelDebts/destroy', [StaffController::class, 'fuelDebt_destroy'])->name('fuelDebts.destroy');
    Route::get('fuelDebts/{id}/cdebt',[StaffController::class, 'cdebt'])->name('fuelDebts.cdebt');
    Route::get('fuelDebts/{id}/payment',[StaffController::class, 'payment'])->name('fuelDebts.payment');
    Route::post('fuelDebts/store_payment',[StaffController::class, 'store_payment'])->name('fuelDebts.pstore');


  

    Route::get('/stock', [StaffController::class, 'stocks_index'])->name('stock.index');
    Route::get('/stock/create', [StaffController::class, 'stocks_create'])->name('stock.create');
    Route::post('/stock/store', [StaffController::class, 'stocks_store'])->name('stock.store');
    Route::get('/stock/show/{stock}/', [StaffController::class, 'stocks_show'])->name('stock.show');
    Route::get('/stock/edit/{stock}/', [StaffController::class, 'stocks_edit'])->name('stock.edit');
    Route::put('/stock/update/{stocks}/', [StaffController::class, 'stocks_update'])->name('stock.update');
    Route::post('/stock/destroy', [StaffController::class, 'stockst_destroy'])->name('stock.destroy');

    Route::get('stocks/stocktypecreate', [StaffController::class, 'stocktypecreate'])->name('stocks.typecreate');
    Route::post('stocks/stocktypecreate',[StaffController::class, 'storetype'])->name('stocks.storetype');  
    Route::get('stocks/{id}/assign', [StaffController::class, 'assignGood'])->name('stocks.assignGood');
    Route::post('stocks/{id}/assign', [StaffController::class, 'assign'])->name('stocks.assign.store');
    Route::get('stocks/{id}/assignEdit', [StaffController::class, 'assignGoodEdit'])->name('stocks.assignGoodEdit');
    Route::post('stocks/{id}/assignEdit', [StaffController::class, 'assignUpdate'])->name('stocks.assign.update');

   

    Route::resource('clientsx',StaffController::class)->except([
        'destroy',
        'index',
        'edit',
        'update',
        'create'
    ]);

    // Route::match(['get', 'post'], 'StaffController', [
    //     'Client_index' => 'submissions.Client_index',
    //     'uses' => 'SubmissionsController@index'
    // ]);

    // Route::match(['get', 'post'], 'Client_index', [
    //     'as' => 'Client_index',
    //     'uses' => [StaffController::class, 'Client_index']
    // ]);
    
    // Route::match(['get', 'post'], 'Client_index', [
    //     'as' => 'Client_index',
    //     'uses' => 'StaffController@Client_index'
    // ]);
    

    
    // Route::get('/drivers/apdf','DriversController@indexapdf')->name('drivers.indexapdf');
    // Route::get('/drivers/pdf','DriversController@indexpdf')->name('drivers.indexpdf');
    Route::get('/clients/pdf',[StaffController::class, 'Client_indexpdf'])->name('clients.indexpdf');
    //Route::get('/trucks/pdf','TruckController@indexpdf')->name('trucks.indexpdf');
    Route::get('/payments/cpdf',[PaymentController::class,'indexcpdf'])->name('payments.indexcpdf');
    Route::get('/payments/pdf',[PaymentController::class,'indexpdf'])->name('payments.indexpdf');
    Route::get('/fuelDebt/pdf/{id}', [FuelDebtController::class, 'indexpdf'])->name('fuelDebt.indexpdf');
    Route::get('/fuelDebt/ppdf/{id}', [FuelDebtController::class, 'indexppdf'])->name('fuelDebt.indexppdf');
    
    Route::get('admin-stock/stocks_assignPDF', [StockController::class, 'stocks_assignPDF'])->name('stocks_assignPDF');




});


// First-run organization setup (see EnsureOrganizationIsSetUp)
Route::get('/setup', [OrganizationController::class, 'setup'])->name('setup');
Route::post('/setup', [OrganizationController::class, 'storeSetup'])->name('setup.store');

Route::get('/access-denied', function () {
    return view('errors.denied');
})->name('denied');


require __DIR__.'/auth.php';