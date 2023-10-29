<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\userController;
use App\Http\controllers\adminController;
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
        return view('welcome');
    });
    Route::view('login','user/login');
    Route::view('/userReg','user/userReg');
    Route::post('/userReg',[userController::class,'userReg'])->name('userReg');
    Route::post('/userlogin',[userController::class,'userlogin'])->name('userlogin');    
    Route::get('logout',[userController::class,'logout']);

Route::middleware(['userGuard'])->group(function(){
    Route::get('/dashboard',[userController::class,'dashboard']);
    Route::get('addExpense',[userController::class,'addExpense']);
    Route::Post('addExpenses',[userController::class,'addExpenseSubmit']);
    Route::get('getItem/{id}',[userController::class,'getItem']);
    Route::get('viewExpenses',[userController::class,'viewExpenses']);
    Route::get('delExpense/{id}',[userController::class,'delExpense']);
    Route::get('editExpense/{id}',[userController::class,'editExpense']);
    Route::post('editExpenseSubmit/{id}',[userController::class,'editExpenseSubmit']);
    Route::get('getWeekExpence',[userController::class,'getWeekExpence']);
});

Route::get('admin',[adminController::class,'admin']);
Route::post('adminlogin',[adminController::class,'adminlogin']);
Route::get('admin/logout',[adminController::class,'adminlogout']);

Route::middleware(['adminGuard'])->group(function(){
Route::get('admin/dashboard',[adminController::class,'dashboard']);
Route::get('admin/addGroup',[adminController::class,'addGroup']);
Route::Post('admin/addGroups',[adminController::class,'addGroupSubmit']);
Route::get('admin/viewGroup',[adminController::class,'viewGroup']);
Route::get('admin/delGroup/{id}',[adminController::class,'delGroup']);
Route::get('admin/editGroup/{id}',[adminController::class,'editGroup']);
Route::post('admin/editGroupSubmit/{id}',[adminController::class,'editGroupSubmit']);

Route::get('admin/addItem',[adminController::class,'addItem']);
Route::Post('admin/addItems',[adminController::class,'addItemSubmit']);
Route::get('admin/viewItem',[adminController::class,'viewItem']);
Route::get('admin/delItem/{id}',[adminController::class,'delItem']);
Route::get('admin/editItem/{id}',[adminController::class,'editItem']);
Route::post('admin/editItemSubmit/{id}',[adminController::class,'editItemSubmit']);


Route::get('admin/viewUser',[adminController::class,'viewUser']);
Route::get('admin/delUser/{id}',[adminController::class,'delUser']);
Route::get('admin/editUser/{id}',[adminController::class,'editUser']);
Route::post('admin/editUserSubmit/{id}',[adminController::class,'editUserSubmit']);
Route::get('admin/viewExpenses/{id}',[adminController::class,'viewExpenses']);


});






