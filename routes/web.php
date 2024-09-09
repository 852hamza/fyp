<?php

// FRONT-END ROUTES
Route::get('/', 'FrontpageController@index')->name('home');
Route::get('/slider', 'FrontpageController@slider')->name('slider.index');

Route::get('/search', 'FrontpageController@search')->name('search');

Route::get('/property', 'PagesController@properties')->name('property');
Route::get('/property/{id}', 'PagesController@propertieshow')->name('property.show');
Route::post('/property/message', 'PagesController@messageAgent')->name('property.message');
Route::post('/property/comment/{id}', 'PagesController@propertyComments')->name('property.comment');
Route::post('/property/rating', 'PagesController@propertyRating')->name('property.rating');
Route::get('/property/city/{cityslug}', 'PagesController@propertyCities')->name('property.city');

Route::get('/agents', 'PagesController@agents')->name('agents');
Route::get('/agents/{id}', 'PagesController@agentshow')->name('agents.show');

Route::get('/gallery', 'PagesController@gallery')->name('gallery');

Route::get('/blog', 'PagesController@blog')->name('blog');
Route::get('/blog/{id}', 'PagesController@blogshow')->name('blog.show');
Route::post('/blog/comment/{id}', 'PagesController@blogComments')->name('blog.comment');

Route::get('/blog/categories/{slug}', 'PagesController@blogCategories')->name('blog.categories');
Route::get('/blog/tags/{slug}', 'PagesController@blogTags')->name('blog.tags');
Route::get('/blog/author/{username}', 'PagesController@blogAuthor')->name('blog.author');

Route::get('/contact', 'PagesController@contact')->name('contact');
// Route::post('/contact', 'PagesController@messageContact')->name('contact.message');
// Web routes file
Route::post('/contact', 'ContactController@sendMessage')->name('contact.send');


Route::get('/about', 'PagesController@about')->name('about');

// // Admin routes in web.php

// // Display user edit form
// Route::get('admin/users/{user}/edit', 'UserController@editUser')->name('users.edit');

// // Update user
// Route::put('admin/users/{user}', 'UserController@updateUser')->name('users.update');

// // Delete user
// Route::delete('admin/users/{user}', 'UserController@deleteUser')->name('users.destroy');

Route::get('/users', 'UserController@index')->name('users.index');  // List users
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');  // Edit user form
Route::put('/users/{user}', 'UserController@update')->name('users.update');  // Update user
Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');  // Delete user


use App\Http\Controllers\CartController;

Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/replace-cart-item', [CartController::class, 'replaceCartItem'])->name('cart.replace');
    Route::post('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Stripe Checkout Routes
    Route::post('/checkout', [CartController::class, 'createCheckoutSession'])->name('checkout.create');
    Route::get('/checkout/success', [CartController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/checkout/cancel', [CartController::class, 'checkoutCancel'])->name('checkout.cancel');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

// Google OAuth Routes
Route::get('login/google', 'Auth\LoginController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::post('/username-check', 'Auth\RegisterController@checkUsername')->name('username.check');
Route::post('/name-check', 'Auth\RegisterController@checkName')->name('name.check');


Route::post('/email-check', 'Auth\RegisterController@checkEmail')->name('email.check');


Route::group(['middleware' => ['auth', 'agent']], function () {
    Route::get('agent/properties', 'PropertyController@index')->name('agent.properties');
    Route::get('agent/properties/create', 'PropertyController@create')->name('agent.properties.create');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('tags', 'TagController');
    Route::resource('categories', 'CategoryController');
    Route::resource('posts', 'PostController');
    Route::resource('features', 'FeatureController');
    Route::resource('properties', 'PropertyController');
    Route::post('properties/gallery/delete', 'PropertyController@galleryImageDelete')->name('gallery-delete');

    Route::resource('sliders', 'SliderController');
    Route::resource('services', 'ServiceController');
    Route::resource('testimonials', 'TestimonialController');

    Route::get('galleries/album', 'GalleryController@album')->name('album');
    Route::post('galleries/album/store', 'GalleryController@albumStore')->name('album.store');
    Route::get('galleries/{id}/gallery', 'GalleryController@albumGallery')->name('album.gallery');
    Route::post('galleries', 'GalleryController@Gallerystore')->name('galleries.store');

    Route::get('settings', 'DashboardController@settings')->name('settings');
    Route::post('settings', 'DashboardController@settingStore')->name('settings.store');

    Route::get('profile', 'DashboardController@profile')->name('profile');
    Route::post('profile', 'DashboardController@profileUpdate')->name('profile.update');

    Route::get('message', 'DashboardController@message')->name('message');
    Route::get('message/read/{id}', 'DashboardController@messageRead')->name('message.read');
    Route::get('message/replay/{id}', 'DashboardController@messageReplay')->name('message.replay');
    Route::post('message/replay', 'DashboardController@messageSend')->name('message.send');
    Route::post('message/readunread', 'DashboardController@messageReadUnread')->name('message.readunread');
    Route::delete('message/delete/{id}', 'DashboardController@messageDelete')->name('messages.destroy');
    Route::post('message/mail', 'DashboardController@contactMail')->name('message.mail');

    Route::get('changepassword', 'DashboardController@changePassword')->name('changepassword');
    Route::post('changepassword', 'DashboardController@changePasswordUpdate')->name('changepassword.update');
});

Route::group(['prefix' => 'agent', 'namespace' => 'Agent', 'middleware' => ['auth', 'agent'], 'as' => 'agent.'], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('profile', 'DashboardController@profile')->name('profile');
    Route::post('profile', 'DashboardController@profileUpdate')->name('profile.update');
    Route::get('changepassword', 'DashboardController@changePassword')->name('changepassword');
    Route::post('changepassword', 'DashboardController@changePasswordUpdate')->name('changepassword.update');
    Route::resource('properties', 'PropertyController');
    Route::post('properties/gallery/delete', 'PropertyController@galleryImageDelete')->name('gallery-delete');

    Route::get('message', 'DashboardController@message')->name('message');
    Route::get('message/read/{id}', 'DashboardController@messageRead')->name('message.read');
    Route::get('message/replay/{id}', 'DashboardController@messageReplay')->name('message.replay');
    Route::post('message/replay', 'DashboardController@messageSend')->name('message.send');
    Route::post('message/readunread', 'DashboardController@messageReadUnread')->name('message.readunread');
    Route::delete('message/delete/{id}', 'DashboardController@messageDelete')->name('messages.destroy');
    Route::post('message/mail', 'DashboardController@contactMail')->name('message.mail');
});

Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user'], 'as' => 'user.'], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('profile', 'DashboardController@profile')->name('profile');
    Route::post('profile', 'DashboardController@profileUpdate')->name('profile.update');
    Route::get('changepassword', 'DashboardController@changePassword')->name('changepassword');
    Route::post('changepassword', 'DashboardController@changePasswordUpdate')->name('changepassword.update');

    Route::get('message', 'DashboardController@message')->name('message');
    Route::get('message/read/{id}', 'DashboardController@messageRead')->name('message.read');
    Route::get('message/replay/{id}', 'DashboardController@messageReplay')->name('message.replay');
    Route::post('message/replay', 'DashboardController@messageSend')->name('message.send');
    Route::post('message/readunread', 'DashboardController@messageReadUnread')->name('message.readunread');
    Route::delete('message/delete/{id}', 'DashboardController@messageDelete')->name('messages.destroy');
});
