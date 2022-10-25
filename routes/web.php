<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PaymentDWController;
use App\Http\Controllers\PaymentAirflowController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\WarehouseController;


//-----------------------------------------------------------------------------------------------
// simple crud routing
Route::get('/',[StudentController::class,'view']);
Route::get('/insert',[StudentController::class,'insert']);
Route::post('/insert',[StudentController::class,'store'])->name('student.store');
Route::get('/delete',[StudentController::class,'delete'])->name('student.delete');
Route::get('/edit/',[StudentController::class,'edit'])->name('student.edit');
Route::post('/update/',[StudentController::class,'update'])->name('student.update');

// ajax crud routing
Route::post('/save',[StudentController::class,'saveData'])->name('student.store');
Route::get('show-std',[StudentController::class,'fetchData']);
Route::delete('deleteStd/{id}',[StudentController::class,'deleteData']);
//-----------------------------------------------------------------------------------------------
Route::get('/h', [ProgramController::class,'index']);
Route::resource('program', ProgramController::class);
// Route::resource('program', ProgramController::class);
Route::get('program/createtable/database/{nama}', [DatabaseController::class,'addtable'])->name('database.addtable');
Route::post('program/createtable', [DatabaseController::class,'storetable'])->name('storetable');
Route::get('program/database/table/{database}', [DatabaseController::class,'show'])->name('database.show');
Route::get('program/database/{database}', [DatabaseController::class,'data'])->name('database.data');
Route::delete('program/database/{database}', [DatabaseController::class,'destroy'])->name('database.destroy');

Route::get('program/createtable/warehouse/{nama}', [WarehouseController::class,'addtable'])->name('warehouse.addtable');
Route::post('program/warehouse', [WarehouseController::class,'storetable'])->name('storetable2');
Route::get('program/warehouse/table/{database}', [WarehouseController::class,'show'])->name('warehouse.show');
Route::get('program/warehouse/{database}', [WarehouseController::class,'data'])->name('warehouse.data');
Route::delete('program/warehouse/{database}', [WarehouseController::class,'destroy'])->name('warehouse.destroy');

Route::resource('program/paymentairflow', PaymentAirflowController::class);


Route::get('/getProgram', [DatabaseController::class, 'getProgram'])->name('getProgram');


