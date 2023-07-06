<?php

use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("addNote",[NoteController::class,"addNote"]);
Route::post("updateNote",[NoteController::class,"updateNote"]);
Route::post("deleteNote",[NoteController::class,"deleteNote"]);
Route::get("getNotes",[NoteController::class,"getNotes"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
