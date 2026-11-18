<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{SiteController, AuthController, StudentController, VendorController, AdminController, SharedController};

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/explore', 'explore')->name('explore');
    Route::get('/restaurants', 'restaurants')->name('restaurants');
    Route::get('/restaurants/{vendor}', 'restaurant')->name('restaurant.show');
    Route::get('/how-it-works', 'how')->name('how');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'send')->name('contact.send');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register/student', 'studentForm')->name('register.student');
    Route::post('/register/student', 'student');
    Route::get('/register/vendor', 'vendorForm')->name('register.vendor');
    Route::post('/register/vendor', 'vendor');
    Route::get('/forgot-password', 'forgotForm')->name('password.request');
    Route::post('/forgot-password', 'forgot')->name('password.email');
    Route::get('/reset-password/{token}', 'resetForm')->name('password.reset');
    Route::post('/reset-password', 'reset')->name('password.update');
});
Route::middleware('auth')->controller(SharedController::class)->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::put('/profile', 'update')->name('profile.update');
    Route::put('/profile/password', 'password')->name('profile.password');
    Route::get('/notifications', 'notices')->name('notices');
    Route::get('/orders/{order}', 'order')->name('order.show');
});
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->controller(StudentController::class)->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');
    Route::get('/cart', 'cart')->name('cart');
    Route::post('/cart/add/{food}', 'add')->name('cart.add');
    Route::post('/cart/update', 'updateCart')->name('cart.update');
    Route::get('/cart/remove/{food}', 'remove')->name('cart.remove');
    Route::get('/checkout', 'checkout')->name('checkout');
    Route::post('/checkout', 'place')->name('checkout.place');
    Route::get('/orders', 'orders')->name('orders');
    Route::post('/orders/{order}/cancel', 'cancel')->name('cancel');
});
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->controller(VendorController::class)->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');
    Route::get('/foods', 'foods')->name('foods');
    Route::get('/foods/create', 'foodForm')->name('foods.create');
    Route::get('/foods/{food}/edit', 'foodForm')->name('foods.edit');
    Route::post('/foods', 'foodSave')->name('foods.store');
    Route::put('/foods/{food}', 'foodSave')->name('foods.update');
    Route::post('/foods/{food}/toggle', 'toggle')->name('foods.toggle');
    Route::delete('/foods/{food}', 'foodDelete')->name('foods.delete');
    Route::get('/categories', 'categories')->name('categories');
    Route::post('/categories', 'categorySave')->name('categories.store');
    Route::get('/orders', 'orders')->name('orders');
    Route::post('/orders/{order}/status', 'status')->name('status');
    Route::post('/orders/{order}/paid', 'paid')->name('paid');
    Route::get('/restaurant', 'restaurant')->name('restaurant');
    Route::put('/restaurant', 'restaurantSave')->name('restaurant.update');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');
    Route::get('/students', 'students')->name('students');
    Route::get('/vendors', 'vendors')->name('vendors');
    Route::post('/users/{user}/status', 'userStatus')->name('user.status');
    Route::post('/vendors/{vendor}/status', 'vendorStatus')->name('vendor.status');
    Route::get('/foods', 'foods')->name('foods');
    Route::delete('/foods/{food}', 'foodDelete')->name('foods.delete');
    Route::post('/foods/{food}/toggle', 'toggle')->name('foods.toggle');
    Route::get('/categories', 'categories')->name('categories');
    Route::post('/categories', 'categorySave')->name('categories.store');
    Route::delete('/categories/{category}', 'categoryDelete')->name('categories.delete');
    Route::get('/hostels', 'hostels')->name('hostels');
    Route::post('/hostels', 'hostelSave')->name('hostels.store');
    Route::post('/hostels/{hostel}/status', 'hostelStatus')->name('hostels.status');
    Route::delete('/hostels/{hostel}', 'hostelDelete')->name('hostels.delete');
    Route::get('/orders', 'orders')->name('orders');
    Route::get('/users', 'users')->name('users');
    Route::post('/users/{user}/role', 'userRole')->name('user.role');
    Route::get('/reports', 'reports')->name('reports');
    Route::get('/messages', 'messages')->name('messages');
    Route::delete('/messages/{message}', 'messageDelete')->name('messages.delete');
    Route::get('/settings', 'settings')->name('settings');
    Route::put('/settings', 'settingsSave')->name('settings.save');
});
