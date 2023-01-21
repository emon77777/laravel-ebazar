<?php

use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PageController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\VerificationController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\FrontController;
use App\Http\Controllers\Frontend\ProductReviewController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/home',[OrderController::class,'index']);

Route::get('profile',[CustomerController::class,'profile'])->name('customer.profile');
Route::post('profile/{id}/update',[CustomerController::class,'update'])->name('profile.update');
Route::post('profile/billing',[CustomerController::class,'billing'])->name('profile.billing');
Route::post('profile/shipping',[CustomerController::class,'shipping'])->name('profile.shipping');
Route::post('profile/{id}/image',[CustomerController::class,'image'])->name('profile.image');
Route::post('change-password',[CustomerController::class,'changePassword'])->name('customer.change-password');
Route::get('wishlist',[WishlistController::class,'index'])->name('wishlist');
Route::post('wish-to-cart',[WishlistController::class,'wishToCart'])->name('customer.wishToCart');
Route::post('removeFromWishlist',[WishlistController::class,'removeFromWishlist'])->name('customer.removeFromWishlist');
Route::post('customer/review',[ProductReviewController::class,'store'])->name('customer.review');

Route::post('customer/add-to-wishlist',[WishlistController::class,'store'])->name('customer.addToWishlist');

Route::post('customer/add-to-cart',[CartController::class,'addToCart'])->name('customer.addToCart');
Route::post('customer/update-cart',[CartController::class,'updateCart'])->name('customer.updateCart');
Route::post('customer/remove-from-cart',[CartController::class,'removeFromCart'])->name('customer.removeFromCart');


Route::get('checkout',[PageController::class,'checkout'])->name('checkout');
Route::post('payment',[PaymentController::class,'index'])->name('customer.payment');
Route::post('stripe',[PaymentController::class,'stripe'])->name('customer.stripe');
Route::post('paypal',[PaymentController::class,'paypal'])->name('customer.paypal');
Route::post('razorpay',[PaymentController::class,'razorpay'])->name('customer.razorpay');
Route::post('paypal/order',[PaymentController::class,'paypalOrder'])->name('customer.paypal-order');
Route::get('payment-success',[PaymentController::class,'paymentSuccess'])->name('customer.payment-success');
Route::get('payment-cancel',[FrontController::class,'paymentCancel'])->name('customer.payment-cancel');

/** Pages routes */
Route::get('order',[OrderController::class,'index'])->name('customer.order');
Route::post('order/cancel/{id}',[OrderController::class,'cancel'])->name('customer.order.cancel');
Route::get('invoice/{order}',[OrderController::class,'invoice'])->name('customer.invoice');
Route::get('invoice-download/{order}',[OrderController::class,'invoiceDownload'])->name('customer.invoice-download');
Route::get('order/details/{order}',[OrderController::class,'details'])->name('order.details');
Route::get('order/order-cancel/{order}',[OrderController::class,'orderCancel'])->name('order.order-cancel');

/** Customer Auth Routes */
Route::get('login',[LoginController::class,'showLoginForm'])->name('customer.login');
Route::post('/login',[LoginController::class,'login']);
Route::get('register',[RegisterController::class,'showRegisterForm'])->name('customer.register');
Route::post('register',[RegisterController::class,'register']);
Route::get('/logout',[LoginController::class,'logout'])->name('customer.logout');
Route::get('/auth/email',[ForgotPasswordController::class,'showLinkRequestForm'])->name('customer.password.email');
Route::post('/password/send',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('customer.password.send');

Route::get('customer/password/reset',[ResetPasswordController::class,'showResetForm'])->name('customer.password.reset');
Route::post('customer/password/reset',[ResetPasswordController::class,'reset'])->name('customer.reset');
Route::post('/logout',[LoginController::class,'logout']);

/** Email Verification Routes */
Route::post('email/resend',[VerificationController::class,'resend'])->name('verification.resend');
Route::get('email/verify/{id}/{hash}',[VerificationController::class,'verify'])->name('verification.verify');

/** Order page ajax routes */
Route::post('order/list',[OrderController::class,'list'])->name('customer.order.list');
