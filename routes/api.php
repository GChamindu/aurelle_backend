<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\NewSectionController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SitemapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::controller(ProductController::class)->group(function () {
    Route::get('/new-arrivals', 'getNewArrivals')->name('products.new.arrivals');
    Route::get('/trending-now', 'getTrendingNow')->name('products.trending.now');
    Route::get('/best-sales', 'getBestSales')->name('products.best.sales');
    Route::get('/recently-viewed', 'getRecentviews')->name('products.recent.views');
    Route::get('/people-bought', 'getPeopleBoughts')->name('products.people.bought');
    Route::get('/shop-grams', 'getShopGrams')->name('products.shop.grams');


    Route::get('/all-products', 'getAllProducts')->name('get.all.products');
    // routes/api.php
    Route::get('/products/{slug}', [ProductController::class, 'getProductDetails']);


    // for the shop page and filters
    Route::get('/shop-filters', 'getShopFilters')->name('get.shop.filters');
    Route::get('/shop', 'shop')->name('get.shop');

    // wishlist

    Route::get('/wishlist', 'getWishlistProducts')->name('get.wishlist');
    Route::get('/new-fashion', 'getNewFashion')->name('products.new.fashion');

    Route::get('/collection/{slug}', 'getCollectionProducts')->name('get.collection.products');
    Route::get('/section/{slug}', 'getSectionProducts')->name('get.section.products');

    Route::get('/category/{slug}',  'getCategoryProducts')->name('get.category.products');
    Route::get('/product/{slug}/size-chart', 'getSizeChart')->name('get.product.size.chart');
});

// routes/api.php
Route::get('/search', [ProductController::class, 'search']);
Route::get('/quick-links', [ProductController::class, 'getQuickLinks']);

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'getCategories')->name('get.categories');
});

Route::controller(CollectionController::class)->group(function () {
    Route::get('/collections', 'getCollections')->name('get.collections');
});


// Route::controller(SeoController::class)->group(function () {
//     Route::get('/category-keywords/{slug}', 'getCategoryRelatedKeywords')
//         ->name('get.category.keywords');
// });


Route::get('/category-keywords/{slug}', [SeoController::class, 'getCategoryRelatedKeywords']);
Route::get('/product-seo/{slug}', [SeoController::class, 'getProductSeoData']);
// Route::get('/category-keywords/{slug}', [SeoController::class, 'getCategoryRelatedKeywords']);
Route::get('/seo/category/{slug}', [SeoController::class, 'getCategorySeo']);
Route::get('/seo/collection/{slug}', [SeoController::class, 'getCollectionSeo']);
Route::get('/seo/section/{slug}', [SeoController::class, 'getSectionSeo']);

Route::get('/collection-keywords/{slug}', [SeoController::class, 'getCollectionRelatedKeywords']);
Route::get('/seo/collections', [SeoController::class, 'getAllCollectionsSeo']);
Route::get('/seo/shop', [SeoController::class, 'getAllProductsSeo']);

Route::get('/seo/new-arrivals', [SeoController::class, 'getNewArrivalsSeo']);


Route::controller(NewSectionController::class)->group(function () {
    Route::get('/sections', 'getSectionsForHeader')->name('get.sections');
});


Route::controller(OrderController::class)->group(function () {
    Route::post('/place-order', 'placeOrder')->name('place.order');

    Route::post('payhere/notify',   'notify')->name('payhere.notify');
    Route::get('payhere/return',   'return')->name('payhere.return');
    Route::get('payhere/cancel',  'cancel')->name('payhere.cancel');
});

Route::post('/api/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

Route::get('/sitemap', [SitemapController::class, 'index']);

Route::post('/newsletter/subscribe', [NewsletterSubscriberController::class, 'store'])->name('newsletter.subscribe');

Route::post('/contact/store', [ContactMessageController::class, 'store'])->name('contact.store');




Route::controller(NewSectionController::class)->group(function () {
    Route::get('/sections', 'getSections')->name('get.sections');
});
