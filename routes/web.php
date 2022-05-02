<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\TestSendEmailController;
// Admin Controllers
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ServePrivateStorage;
use App\Http\Controllers\Admin\MediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('send-mail', [TestSendEmailController::class, 'sendEmail']);

// Client
Route::group(['prefix' => '/', 'as' => 'client.'], function () {
    Route::get(
        '',
        [HomeController::class, 'index']
    )->name('home');

    Route::get(
        'contact',
        [HomeController::class, 'contact']
    )->name('contact');

    Route::get(
        'about',
        [HomeController::class, 'about']
    )->name('about');

    Route::get(
        'shop',
        [ProductController::class, 'shopAll']
    )->name('shop');

    Route::get(
        'service-shop',
        [ServiceController::class, 'shopAll']
    )->name('serviceShop');

    Route::get(
        'detail/{id}',
        [ProductController::class, 'detail']
    )->name('detail');

    Route::get(
        'service-detail/{id}',
        [ServiceController::class, 'serviceDetail']
    )->name('serviceDetail');

    Route::get(
        'cart',
        [CartController::class, 'cart']
    )->name('cart');

    Route::post(
        'add-to-cart',
        [CartController::class, 'add']
    )->name('addToCart');

    Route::post(
        'remove-from-cart',
        [CartController::class, 'remove']
    )->name('rmFromCart');

    Route::post(
        'update-cart-quantity',
        [CartController::class, 'updateQuantity']
    )->name('updateCartQuantity');

    Route::get(
        'checkout',
        [CheckoutController::class, 'checkout']
    )->name('checkout');

    Route::post('post-checkout', [CheckoutController::class, 'postCheckout'])->name('postCheckout');

    Route::get(
        'order-completed',
        [CheckoutController::class, 'completeOrder']
    )->name('orderCompleted');

    Route::get(
        'login',
        [UserController::class, 'login']
    )->name('login');

    Route::post('/post-login', [UserController::class, 'postLogin'])->name('postLogin');

    Route::get(
        'register',
        [UserController::class, 'register']
    )->name('register');

    Route::post('/post-register', [UserController::class, 'postRegister'])->name('postRegister');

    Route::get('/logout', [UserController::class, 'signOut'])->name('logout');

    Route::get('/quick-view/{id}', [ProductController::class, 'quickView'])->name('quickView');

    //Delivery
    Route::post('/select-delivery', [CheckoutController::class, 'selectDelivery'])->name('checkout.select.delivery');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'authen'], function () {
    // Route::prefix('/admin')->middleware([Auth::class])->group(['as' => 'admin.'], function () {
    Route::get(
        '/home',
        [AdminHomeController::class, 'index']
    )->name('home');

    //Product
    Route::get(
        '/product',
        [AdminProductController::class, 'index']
    )->name('product');

    Route::get(
        '/product/edit/{id}',
        [AdminProductController::class, 'edit']
    )->name('editProductGet');

    Route::post(
        '/product/edit',
        [AdminProductController::class, 'edit']
    )->name('editProductPost');

    Route::get(
        '/product/add',
        [AdminProductController::class, 'add']
    )->name('addProductGet');

    Route::post(
        '/product/add',
        [AdminProductController::class, 'add']
    )->name('addProductPost');

    Route::post(
        '/product/change-status',
        [AdminProductController::class, 'changeStatus']
    )->name('changeProductStatus');

    Route::post(
        '/product/delete',
        [AdminProductController::class, 'delete']
    )->name('deleteProductPost');

    //Service
    Route::get(
        '/service',
        [AdminServiceController::class, 'index']
    )->name('service');

    Route::get(
        '/service/edit/{id}',
        [AdminServiceController::class, 'edit']
    )->name('editServiceGet');

    Route::post(
        '/service/edit',
        [AdminServiceController::class, 'edit']
    )->name('editServicePost');

    Route::get(
        '/service/add',
        [AdminServiceController::class, 'add']
    )->name('addServiceGet');

    Route::post(
        '/service/add',
        [AdminServiceController::class, 'add']
    )->name('addServicePost');

    Route::post(
        '/service/change-status',
        [AdminServiceController::class, 'changeStatus']
    )->name('changeServiceStatus');

    Route::post(
        '/service/delete',
        [AdminServiceController::class, 'delete']
    )->name('deleteServicePost');


    // category
    Route::get(
        '/category',
        [AdminCategoryController::class, 'index']
    )->name('category');

    Route::get(
        '/category/add',
        [AdminCategoryController::class, 'add']
    )->name('addCategoryGet');

    Route::post(
        '/category/add',
        [AdminCategoryController::class, 'add']
    )->name('addCategoryPost');

    Route::get(
        '/category/edit/{id}',
        [AdminCategoryController::class, 'edit']
    )->name('editCategoryGet');

    Route::post(
        '/category/edit',
        [AdminCategoryController::class, 'edit']
    )->name('editCategoryPost');

    Route::post(
        '/category/delete',
        [AdminCategoryController::class, 'delete']
    )->name('deleteCategory');

    // service category
    Route::get(
        '/service-category',
        [AdminServiceCategoryController::class, 'index']
    )->name('serviceCategory');

    Route::get(
        '/service-category/add',
        [AdminServiceCategoryController::class, 'add']
    )->name('addServiceCategoryGet');

    Route::post(
        '/service-category/add',
        [AdminServiceCategoryController::class, 'add']
    )->name('addServiceCategoryPost');

    Route::get(
        '/service-category/edit/{id}',
        [AdminServiceCategoryController::class, 'edit']
    )->name('editServiceCategoryGet');

    Route::post(
        '/service-category/edit',
        [AdminServiceCategoryController::class, 'edit']
    )->name('editServiceCategoryPost');

    Route::post(
        '/service-category/delete',
        [AdminServiceCategoryController::class, 'delete']
    )->name('deleteServiceCategory');

    Route::get('/sign-out', [AuthenticationController::class, 'signOut'])->name('administrator.signOutAdmin');

    // API routes
    Route::group(['prefix' => '/api', 'as' => 'api.'], function () {
        Route::get(
            '/categories-lv2/{level1Id}',
            [AdminCategoryController::class, 'getLvl2CategoriesAPI']
        )->name('categoriesLv2');
        Route::post('/upload-images', [AdminProductController::class, 'uploadImages'])->name('uploadImages');
        Route::post('/delete-image', [AdminProductController::class, 'deleteImage'])->name('deleteImage');
        Route::post('/update-status',
            [AdminCategoryController::class, 'updateStatus']
        )->name('updateCategoryStatus');
    });


    // API routes
    Route::group(['prefix' => '/api', 'as' => 'api.'], function () {
        Route::get(
            '/service-categories-lv2/{level1Id}',
            [AdminServiceCategoryController::class, 'getLvl2CategoriesAPI']
        )->name('serviceCategoriesLv2');
        Route::post('/upload-images', [AdminServiceCategoryController::class, 'uploadImages'])->name('uploadImages');
        Route::post('/delete-image', [AdminServiceCategoryController::class, 'deleteImage'])->name('deleteImage');
        Route::post('/update-service-status',
            [AdminServiceCategoryController::class, 'updateStatus']
        )->name('updateServiceCategoryStatus');
    });

    // START Media routes
    Route::get('media', [MediaController::class, 'index'])->name('media');
    Route::post('media/upload', [MediaController::class, 'upload'])->name('uploadMediaPost');
    Route::post('media/remove', [MediaController::class, 'remove'])->name('removeMedia');
    // END Media routes

    // start USER
    Route::get(
        '/user',
        [AdminUserController::class, 'index']
    )->name('user');

    Route::post(
        '/user/delete',
        [AdminUserController::class, 'delete']
    )->name('deleteUser');
    // add USER

    // start BRAND
    Route::get(
        '/brand',
        [AdminBrandController::class, 'index']
    )->name('brand');

    Route::post(
        '/brand/delete',
        [AdminBrandController::class, 'delete']
    )->name('deleteBrand');

    Route::get(
        '/brand/add',
        [AdminBrandController::class, 'add']
    )->name('addBrandGet');

    Route::post(
        '/brand/add',
        [AdminBrandController::class, 'add']
    )->name('addBrandPost');

    Route::get(
        '/brand/edit/{id}',
        [AdminBrandController::class, 'edit']
    )->name('editBrandGet');

    Route::post(
        '/brand/edit',
        [AdminBrandController::class, 'edit']
    )->name('editBrandPost');
    // end BRAND

    // start SLIDER
    Route::get(
        '/slider',
        [AdminSliderController::class, 'index']
    )->name('slider');

    Route::post(
        '/slider/delete',
        [AdminSliderController::class, 'delete']
    )->name('deleteSlider');

    Route::get(
        '/slider/add',
        [AdminSliderController::class, 'add']
    )->name('addSliderGet');

    Route::post(
        '/slider/add',
        [AdminSliderController::class, 'add']
    )->name('addSliderPost');

    Route::get(
        '/slider/edit/{id}',
        [AdminSliderController::class, 'edit']
    )->name('editSliderGet');

    Route::post(
        '/slider/edit',
        [AdminSliderController::class, 'edit']
    )->name('editSliderPost');
    // end SLIDER

    // start ORDER
    Route::get(
        '/order',
        [AdminOrderController::class, 'index']
    )->name('order');

    Route::post(
        '/order/delete',
        [AdminOrderController::class, 'delete']
    )->name('deleteOrder');

    Route::get(
        '/order/add',
        [AdminOrderController::class, 'add']
    )->name('addOrderGet');

    Route::post(
        '/order/add',
        [AdminOrderController::class, 'add']
    )->name('addOrderPost');

    Route::get(
        '/order/edit/{id}',
        [AdminOrderController::class, 'edit']
    )->name('editOrderGet');

    Route::post(
        '/order/edit',
        [AdminOrderController::class, 'edit']
    )->name('editOrderPost');
    // end ORDER

    // start ORDERDETAIL
    Route::get(
        '/orderDetail/add/{id}',
        [AdminOrderController::class, 'addOrderDetail']
    )->name('addOrderDetailGet');

    Route::post(
        '/orderDetail/add',
        [AdminOrderController::class, 'addOrderDetail']
    )->name('addOrderDetailPost');


    Route::get(
        '/orderDetail/edit/{id}',
        [AdminOrderController::class, 'editOrderDetail']
    )->name('editOrderDetailGet');

    Route::post(
        '/orderDetail/edit',
        [AdminOrderController::class, 'editOrderDetail']
    )->name('editOrderDetailPost');


    Route::get(
        '/orderDetail/{id}',
        [AdminOrderController::class, 'orderDetail']
    )->name('orderDetail');



    Route::post(
        '/deleteOrderDetail',
        [AdminOrderController::class, 'deleteOrderDetail']
    )->name('deleteOrderDetail');



    // end ORDERDETAIL

});

Route::get('/administrator/get-sign-in', [AuthenticationController::class, 'getSignIn'])->name('administrator.getSignIn');
Route::post('/administrator/post-sign-in', [AuthenticationController::class, 'postSignIn'])->name('administrator.postSignIn');

Route::get('private-storage/{media}/{filename}', ServePrivateStorage::class)
    ->middleware('signed')
    ->name('private-storage');
