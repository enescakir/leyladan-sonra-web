<?php

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


Route::get('/', 'FrontController@home')->name('front.home');
Route::get('/hakkimizda/basinda-biz.html', 'FrontController@news')->name('front.news');
Route::get('/hakkimizda/biz-kimiz.html', 'FrontController@us')->name('front.us');
Route::get('/hakkimizda/basin-kiti.html', 'FrontController@newskit')->name('front.newskit');
Route::get('/hakkimizda/destek-verenler.html', 'FrontController@sponsors')->name('front.sponsors');
Route::get('/neler-soylediniz.html', 'FrontController@testimonials')->name('front.testimonials');
Route::post('/neler-soylediniz', 'FrontController@testimonialStore')->name('front.testimonial.store');
Route::get('/leyla-kimdir.html', 'FrontController@leyla')->name('front.leyla');
Route::get('/sikca-sorulan-sorular.html', 'FrontController@sss')->name('front.sss');
Route::get('/blog.html', 'FrontController@blogs')->name('front.blogs');
Route::get('/blog/{name}.html', 'FrontController@blog')->name('front.blog');
Route::get('/fakülteler.html', 'FrontController@faculties')->name('front.faculties');
Route::get('/gizlilik-politikasi.html', 'FrontController@privacy')->name('front.privacy');
Route::get('/kullanim-sartlari.html', 'FrontController@tos')->name('front.tos');
Route::get('/iletisim.html', 'FrontController@contact')->name('front.contact');
Route::post('/iletisim', 'FrontController@contactStore')->name('front.contact.store');
Route::post('/newsletter', 'FrontController@newsletter')->name('front.newsletter');
Route::get('/cities', 'FrontController@cities')->name('admin.front.cities');
Route::get('/city/{code}', 'FrontController@city')->name('admin.front.city');
Route::get('/english.html', 'FrontController@english')->name('front.english');
Route::get('/kan-bagisi.html', 'FrontController@blood')->name('front.blood');
Route::get('/mobil-uygulama.html', 'FrontController@appLanding')->name('front.landing');
Route::post('/kan-bagisi', 'FrontController@bloodStore')->name('front.blood.store');
Route::get('/bekleyen-hediyeler', 'FrontController@waitings');
Route::post('/bekleyen-hediyeler', 'FrontController@waitings');

Route::get('/yonetim', function () { return redirect('/admin/login'); })->name('admin');

Route::get('/{facultyName}.html', 'FrontController@faculty')->name('front.faculty');
Route::post('/{facultyName}/{childSlug}', 'FrontController@childMessage')->name('front.child.message');
Route::get('/{facultyName}/{childSlug}.html', 'FrontController@child')->name('front.child');
