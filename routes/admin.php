<?php

use App\Http\Controllers\Admin\AdminController;



use App\Http\Controllers\Admin\AttachPermissionToRoleController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeleteImageController;
use App\Http\Controllers\Admin\DetachPermissionFromRoleController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\UploadImagesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\AttrvaluesController;
use App\Http\Controllers\Admin\FlashdealController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','admin'])->group(function () {
    // Route::get('dashboard', DashboardController::class)->name('dashboard');
    // Route::post('roles/attach-permission', AttachPermissionToRoleController::class)->name('roles.attach-permission');
    // Route::post('roles/detach-permission', DetachPermissionFromRoleController::class)->name('roles.detach-permission');
    // Route::resource('roles', RolesController::class);
    // Route::resource('permissions', PermissionsController::class);
    // Route::resource('users', UsersController::class);
    // Route::resource('categories', CategoryController::class);
    // Route::resource('products', ProductController::class);
    // Route::post('upload-images', UploadImagesController::class)->name('images.store');
    // Route::post('delete-images', DeleteImageController::class)->name('images.destroy');


    // Route::get('/', [AdminController::class, 'index']);
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AdminController::class, 'logout']);
    Route::any('general-settings', [SettingsController::class, 'general_settings']);
    Route::any('profile-settings', [SettingsController::class, 'profile_settings'])->name('profile_settings');
    Route::post('profile-settings/change-password', [SettingsController::class, 'change_password'])->name('profile_settings.change_password');
    Route::any('social-settings', [SettingsController::class, 'social_settings'])->name('social_settings');
    // Route::resource('banner', BannerController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubcategoryController::class);
    Route::resource('products', ProductController::class);
    Route::delete('products/{id}/image/{name}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
    // Route::post('get-attrvalue', [ProductController::class, 'get_attrvalue']);
    // Route::resource('tax', TaxController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('attribute', AttributeController::class);
    Route::resource('attribute-values', AttrvaluesController::class);
    // Route::resource('countries', CountryController::class);
    // Route::resource('states', StateController::class);
    // Route::resource('cities', CityController::class);
    // Route::resource('pages', PagesController::class);
    Route::resource('orders', OrderController::class);
    Route::get('orders/{id}/view_order', [OrderController::class, 'view_order'])->name('view_order');
    Route::post('order-product/delivered', [OrderController::class, 'changeDelivery'])->name('order_delivered');
    Route::resource('users', UserController::class);
    Route::post('users/block', [UserController::class, 'changeStatus'])->name('users.block');
    // Route::post('page_showIn_header', [PagesController::class, 'show_in_header']);
    // Route::post('page_showIn_footer', [PagesController::class, 'show_in_footer']);
    Route::get('product-sale', [ReportController::class, 'product_sale'])->name('product_sale.index');
    Route::get('product-stock', [ReportController::class, 'product_stock'])->name('product_stock.index');
    // Route::resource('payment-method', PaymentmethodController::class);
    // Route::post('payment-method/status', [PaymentmethodController::class, 'changeStatus']);
    Route::resource('flash-deals', FlashdealController::class);
    Route::post('get-flash', [FlashdealController::class, 'get_flash'])->name('get_flash');
    Route::post('get-flash-edit', [FlashdealController::class, 'get_flash_edit'])->name('get_flash_edit');
    Route::get('reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::post('view_review', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('approve_review', [ReviewController::class, 'approveReview'])->name('reviews.approve');
    Route::post('delete_review', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::any('reviews', [ReviewController::class, 'index'])->name('reviews.index');

});

require __DIR__.'/auth.php';
