<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public routes
Route::post('employee/register', [EmployeeController::class, 'register']);
Route::get('login', [EmployeeController::class, 'login']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
  Route::get('logout', [EmployeeController::class, 'logout']);
  
  //book routes
  Route::post('library/add-book', [BookController::class, 'createBook']);
  Route::get('library/list-book', [BookController::class, 'listBook']);
  Route::get('library/book-detail/{id}', [BookController::class, 'singleBook']);
  Route::put('library/edit-book/{id}', [BookController::class, 'updateBook']);
  Route::delete('library/delete-book/{id}', [BookController::class, 'deleteBook']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
