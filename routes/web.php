<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewSectionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.admin_index');
    });

    Route::prefix('admin')->group(function () {

        Route::get('/categories', function () {
            return view('category.index');
        })->name('admin.categories');


        Route::get('/products', function () {
            return view('products.index');
        })->name('admin.products');


        Route::get('/products-collection', function () {
            return view('products.collection.create');
        })->name('admin.products.collection');

        Route::get('/products-section', function () {
            return view('sections.add-products');
        })->name('admin.products.section');



        Route::get('/collections', function () {
            return view('collections.index');
        })->name('admin.collections');


        Route::get('/sections/products-view', function () {
            return view('sections.view-products');
        })->name('admin.sections.products.view');


        Route::get('/collections/products-view', function () {
            return view('products.collection.index');
        })->name('admin.collections.products.view');


        Route::get('/products-view', function () {
            return view('products.show');
        })->name('admin.products.view');

        Route::get('/orders', function () {
            return view('admin.orders.index');
        })->name('admin.orders');



        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('admin.products.edit');



        // collection products

        Route::get('/collection-products/edit/{product}', [ProductController::class, 'editCollectionProducts'])
            ->name('admin.products.edit-collection');

        Route::put('/products-collection/update/{product}', [ProductController::class, 'updateProductCollections'])
            ->name('admin.collection.products.update');

        // collections



        // sections



        Route::get('/section-products/edit/{product}', [ProductController::class, 'editSectionProducts'])
            ->name('admin.products.edit-section');

        Route::put('/products-section/update/{product}', [ProductController::class, 'updateProductSections'])
            ->name('admin.section.products.update');

        //






        // Route::delete('admin/delete/products/{product}', [ProductController::class, 'destroy'])
        //     ->name('admin.products.destroy');


        Route::controller(MediaController::class)->group(function () {
            Route::post('/media/upload', 'upload')->name('admin.media.upload');
            Route::post('uplod/products', 'uploadProducts')->name('upload.products');
        });
    });


    Route::controller(ProductController::class)->group(function () {
        // Route::get('/products', 'index')->name('admin.products.index');  // Returns products.index view
        Route::get('/products/list', 'list')->name('admin.products.list');  // For DataTables AJAX
        Route::post('/products', 'store')->name('admin.products.store');
        Route::get('/products/{product}', 'show')->name('admin.products.show');
        Route::put('/products/{product}', 'update')->name('admin.products.update');
        Route::delete('/admin/products/{product}', 'destroy')->name('admin.products.destroy');


        Route::delete('/admin/collection-products/{product}', 'destroyCollectionProduct')->name('admin.collection.products.destroy');
        Route::patch('/admin/collection-products/{product}/sold-out', 'toggleCollectionProductSoldOut')->name('admin.collection.products.toggle-sold-out');


        Route::delete('/admin/section-products/{product}', 'destroySectionProducts')->name('admin.section.products.destroy');



        // for the store items in differrnc
        Route::post('store/products', 'store')->name('store.products');
        Route::post('store/collection-products', 'storeCollectionProducts')->name('store.collection.products');
        Route::post('store/section-products', 'storeSectionProducts')->name('store.section.products');


        // routes/web.php

        Route::get('/admin/products/list-view', 'adminProductsListview')->name('admin.products.list.view');
        Route::get('/admin/collection-products/list', 'adminCollectionProductsList')->name('admin.collection.products.list');
        Route::get('/admin/section-products/list', 'adminSectionProductsList')->name('admin.section.products.list');
    });
});



Route::middleware(['auth', 'role:admin'])->prefix('admin')->controller(CategoryController::class)->group(function () {
    Route::get('/categories', fn() => view('category.index'))->name('admin.categories');
    Route::get('/categories/list', 'list');
    Route::post('/categories', 'store');
    Route::get('/categories/{id}', 'show');
    Route::put('/categories/{id}', 'update');
    Route::delete('/categories/{id}', 'destroy');
});




Route::middleware(['auth', 'role:admin'])->prefix('admin')->controller(NewSectionController::class)->group(function () {
    Route::get('/sections', fn() => view('sections.create'))->name('admin.sections');
    Route::get('/sections/list', 'list');
    Route::post('/sections', 'store');
    Route::get('/sections/{id}', 'show');
    Route::put('/sections/{id}', 'update');
    Route::delete('/sections/{id}', 'destroy');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->controller(CollectionController::class)->group(function () {
    Route::get('/collections', fn() => view('collections.index'))->name('admin.collections');
    Route::get('/collections/list', 'list');
    Route::post('/collections', 'store');
    Route::get('/collections/{id}', 'show');
    Route::put('/collections/{id}', 'update');
    Route::delete('/collections/{id}', 'destroy');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->controller(OrderController::class)->group(function () {
    Route::get('/orders', fn() => view('admin.orders.index'))->name('admin.orders');

    // Route::get('/orders/data',  'data')->name('admin.orders.data');
    Route::post('/orders/update-status', 'updateStatus')->name('admin.orders.updateStatus');
    Route::post('/orders/update-items-status', 'updateItemsStatus')->name('admin.orders.items.updateStatus');


    Route::get('/orders/{order}/items', 'orderItems')->name('admin.orders.items');

    Route::get('/orders/data', 'ordersData')->name('admin.orders.data');
});




// Route::get('/', function () {
//     return view('login.index');
// });


// Route::controller(AuthController::class)->group(function () {
//     Route::post('/login', 'login')->name('login');
//     Route::post('/logout', 'logout')->name('logout');
// });


// Show login form (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');  // ← keep the name 'login' so Laravel's default redirect works

// Handle login submission (POST)
Route::post('/login', [AuthController::class, 'login']);

// Optional: root can redirect to login if you prefer
Route::get('/', function () {
    return redirect()->route('login');
});

// Logout (POST)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');






// Route::get('/admin/orders/data', [OrderController::class, 'data'])->name('admin.orders.data');
// Route::post('/admin/orders/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
