<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::apiResource('loans', LoanController::class);
Route::patch('/loans/{id}/return',[LoanController::class,'returned']);