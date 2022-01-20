<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Cities\CitiesController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Categories\CategoryController;
use App\Http\Controllers\Api\Countries\CountriesController;


Route::middleware(['auth:sanctum'])->group(function () {
    //auth
    Route::post('logout', LogoutController::class);

    //profile
    Route::get('me', [ProfileController::class, 'profile']);
    Route::patch('update-basic-data', [ProfileController::class, 'updateBasicData']);
    Route::post('update-address-phone', [ProfileController::class, 'updateAddressAndPhone']);
    Route::post('update-password', [ProfileController::class, 'updatePassword']);
    Route::get('remove-image', [ProfileController::class, 'removeImage']);

    //cart
    Route::resource('cart', CartController::class, [
        'parameters' => [
            'cart' => 'productVariation'
        ]
    ]);
});
// Auth
Route::post('login', LoginController::class);
Route::post('register', RegisterController::class);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
//just for testing password reset link
Route::get('reset-password/{token}', function ($token){
    return $token;
})->name('reset-password');

//categories
Route::get('categories', [CategoryController::class, 'index']);

//products
Route::apiResource('products', ProductController::class, ['only' => ['index', 'show']]);

//get available counties and cities
Route::get('countries', CountriesController::class);
Route::get('cities/{country_id}', CitiesController::class);
