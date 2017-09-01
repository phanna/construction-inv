<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::auth();



Route::get('/','HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/barcodeGenerator', 'HomeController@barcodeGenerator');

//show item in toom for chart
Route::get('/showItemInRoom/{room_name}', 'HomeController@showItemInRoom');

//manage invoice
Route::get('/invoice/create_invoice', 'InvoiceController@selectItem_NewInvoice');
Route::get('/invoice/create_invoice_barcode', 'InvoiceController@selectItem_NewInvoice');
Route::get('/sale/invoice', 'InvoiceController@saleInvNumber');
Route::get('/assign/{staffID}', 'InvoiceController@addItemToStaff');
Route::get('/invoice/update_invoice', 'InvoiceController@fn_Update_invoice');
Route::get('/remove/saleinvItem','InvoiceController@destroy');
Route::get('/item/show', 'InvoiceController@show_item');

//item
Route::get('/newInventory', 'InventoryController@index');
Route::get('/newItemModel', 'InventoryController@addNewItem');
Route::post('/item/saveNewItem', 'InventoryController@create');
Route::get('/get_stock_eachItem/{item_id}', 'InventoryController@get_stock_eachItem');
Route::get('/editInventory/{id}','InventoryController@editItem');
Route::get('/deleteItem','InventoryController@destroyTbl_item');

//manage stock route
Route::get('/showStock/{id}','InventoryController@showStock');
Route::get('/newStockModal/{id}/{status}','InventoryController@modalStock');
Route::post('/addNewStock','InventoryController@createStock');
Route::get('/editStock/{itemID}/{id}/{status}','InventoryController@selectStock');
Route::get('/deleteStock','InventoryController@distroyStock');

//general setting
Route::get('/generalSetting','GeneralSittiing@index');

Route::get('/department','GeneralSittiing@department');
Route::get('/addDepartment','GeneralSittiing@addDepartment');
Route::post('/addDeptForm','GeneralSittiing@creatDeptForm');
Route::get('/editDept/{id}','GeneralSittiing@editDept');
Route::get('/deleteDept',"GeneralSittiing@deleteDept");

Route::get('/permission',"GeneralSittiing@permission");
Route::get('/onChangeUser',"GeneralSittiing@onChangeUser");
Route::get('/onChangeUser/{userID}',"GeneralSittiing@onChangeUser2");
Route::get('/insertPermission',"GeneralSittiing@insertPermission");

Route::get('/categoryItem','GeneralSittiing@categoryItem');
Route::get('/addCategory','GeneralSittiing@addCategory');
Route::post('/addCateForm','GeneralSittiing@createCateForm');
Route::get('/editCate/{id}','GeneralSittiing@editCate');
Route::get('/deleteCate',"GeneralSittiing@deleteCate");

Route::get('/newUser','GeneralSittiing@registerUser');
Route::get('/addUser','GeneralSittiing@addUser');
Route::post('/createNewUser','GeneralSittiing@createNewUser');
Route::get('/editUser/{id}','GeneralSittiing@editUser');
Route::get('/user/emailExist','GeneralSittiing@checkEmailExist');
Route::get('/user/deleteUser','GeneralSittiing@deleteUser');

Route::get('/zone','GeneralSittiing@zone');
Route::post('/addNewZone','GeneralSittiing@createZoneForm');
Route::get('/deleteZone','GeneralSittiing@deleteZone');
Route::get('/EditZone/{id}','GeneralSittiing@EditZone');

Route::get('/itemtozone','GeneralSittiing@itemtozone');
Route::post('/addItemzone','GeneralSittiing@addItemTozone');
Route::get('/EditItemZone/{id}','GeneralSittiing@EditItemZone');
Route::get('/deleteItemZone','GeneralSittiing@deleteItemZone');

//manage suppliers
Route::get('/supplier','SupplierController@index');
Route::get('/newSupplierForm','SupplierController@showForm');
Route::post('/addNewSupplier','SupplierController@create');
Route::get('/getSupplierid/{id}','SupplierController@getSupplierid');
Route::get('/deleteSupplier','SupplierController@deleteSupplier');

//manage receiver
Route::get('/staff','StaffController@index');
Route::get('/newstaffForm','StaffController@newstaffForm');
Route::get('/getstafflId/{id}','StaffController@getstafflId');
Route::post('/submitNewReceiver','StaffController@submitNewReceiver');
Route::get('/deleteReceiver','StaffController@distoyReceiver');

//manage itemunit
Route::get('/itemunit','SupplierController@indexItemUnit');
Route::post('/addNewUnit','SupplierController@createItemUnit');
Route::get('/deleteUnitItem','SupplierController@deleteItemUnit');

//change password
Route::get('/changePassword','GeneralSittiing@changePassword');
Route::post('/updatePassword','GeneralSittiing@updatePassword');

//report reports
Route::get('/reports','ReportController@index');
Route::get('/inventory','ReportController@inventory');

//manage stock request
Route::get('/stockRequest','RequeststockController@index');
Route::get('/stockRequest/{status}','RequeststockController@listRequest');
Route::get('/addnewItem','RequeststockController@addnewItem');
Route::get('/addNewItemRequest','RequeststockController@addNewItemRequest');
Route::get('/loadformItem','RequeststockController@loadformItem');
Route::post('/addItemToInvoid','RequeststockController@addItemToInvoid');
Route::get('/selectItemName/{item_id}','RequeststockController@selectItemName');
Route::get('/getSaleDetailview/{id}','RequeststockController@getSaleDetailview');
Route::get('/editSaleDetail/{id}','RequeststockController@editSaleDetail');

Route::get('/managerapprov','RequeststockController@managerapprov');
Route::get('/approvbymanager/{id}','RequeststockController@approvbymanager');
Route::get('/listmanagerapprov/{status}','RequeststockController@listmanagerapprov');

Route::get('/request_management','RequeststockController@requestManagement');
Route::get('/request_management/{status}','RequeststockController@listRequestManagement');

Route::get('/approvrequest/{id}','RequeststockController@approvrequest');
Route::get('/rejectrequest/{id}','RequeststockController@rejectrequest');

//manage stock out
Route::get('/listStock/{id}','StockController@listStock');
Route::get('/listStockview/{view}/{id}','StockController@listStockview');
Route::get('/warehouse','StockController@warehouse');
Route::post('/addStockOut','StockController@addStockOut');
Route::get('/listWareHouseManagement/{status}','StockController@listWareHouseManagement');

//manage purchasing
Route::get('/purchasing','PurchasController@index');
Route::get('/addNewItemPurchase','PurchasController@addNewItemPurchase');
Route::get('/storeItemPurchase/{item_id}','PurchasController@storeItemPurchase');
Route::post('/addItemToPurchasing','PurchasController@addItemToPurchasing');
Route::get('/viewPurchaseDetail/{id}','PurchasController@viewPurchaseDetail');
Route::get('/editPurchaseDetail/{id}','PurchasController@editPurchaseDetail');
Route::get('/purchasing/{status}','PurchasController@listPurchaseByStatuse');
//
Route::get('/managePurchase','PurchasController@managePurchase');
Route::get('/managePurchase/{status}','PurchasController@listPurchaseManagement');
Route::get('/approvePurchase/{id}','PurchasController@approvePurchase');
Route::get('/rejectPurchase/{id}','PurchasController@rejectPurchase');
//
Route::get('/purchase_managerapprove','PurchasController@purchase_managerapprove');
Route::get('/manageApprovePurchase/{id}','PurchasController@manageApprovePurchase');
Route::get('/listpurchase_managerapprove/{status}','PurchasController@listpurchase_managerapprove');

//stock in
Route::get('/stockin','StockController@stockin');
Route::get('/stockin/{status}','StockController@listStockinstatus');
Route::get('/listStocktakeIn/{id}','StockController@listStocktakeIn');
Route::get('/listStockviewtakeIn/{view}/{id}','StockController@listStockviewtakeIn');
Route::post('/submitStockIn','StockController@submitStockIn');

Route::get('/meeting','HomeController@meeting');
Route::get('/meeting/{id}','HomeController@meeting_');
Route::post('/addpost','HomeController@addpost');
