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

Route::get('/', 'Front\HomeController@home')->name('front.home');
Route::get('/hakkimizda/basinda-biz.html', 'Front\HomeController@news')->name('front.news');
Route::get('/hakkimizda/biz-kimiz.html', 'Front\HomeController@us')->name('front.us');
Route::get('/hakkimizda/basin-kiti.html', 'Front\HomeController@newskit')->name('front.newskit');
Route::get('/hakkimizda/destek-verenler.html', 'Front\HomeController@sponsors')->name('front.sponsors');
Route::get('/neler-soylediniz.html', 'Front\HomeController@testimonials')->name('front.testimonials');
Route::post('/neler-soylediniz', 'Front\HomeController@testimonialStore')->name('front.testimonial.store');
Route::get('/leyla-kimdir.html', 'Front\HomeController@leyla')->name('front.leyla');
Route::get('/sikca-sorulan-sorular.html', 'Front\HomeController@sss')->name('front.sss');
Route::get('/blog.html', 'Front\HomeController@blogs')->name('front.blogs');
Route::get('/blog/{name}.html', 'Front\HomeController@blog')->name('front.blog');
Route::get('/fakülteler.html', 'Front\HomeController@faculties')->name('front.faculties');
Route::get('/gizlilik-politikasi.html', 'Front\HomeController@privacy')->name('front.privacy');
Route::get('/kullanim-sartlari.html', 'Front\HomeController@tos')->name('front.tos');
Route::get('/iletisim.html', 'Front\HomeController@contact')->name('front.contact');
Route::post('/iletisim', 'Front\HomeController@contactStore')->name('front.contact.store');
Route::post('/newsletter', 'Front\HomeController@newsletter')->name('front.newsletter');
Route::get('/cities', 'Front\HomeController@cities')->name('admin.front.cities');
Route::get('/city/{code}', 'Front\HomeController@city')->name('admin.front.city');
Route::get('/english.html', 'Front\HomeController@english')->name('front.english');
Route::get('/kan-bagisi.html', 'Front\HomeController@blood')->name('front.blood');
Route::get('/mobil-uygulama.html', 'Front\HomeController@appLanding')->name('front.landing');
Route::post('/kan-bagisi', 'Front\HomeController@bloodStore')->name('front.blood.store');
Route::get('/bekleyen-hediyeler', 'Front\HomeController@waitings');
Route::post('/bekleyen-hediyeler', 'Front\HomeController@waitings');

Route::get('/yonetim', function () { return redirect('/admin/login'); })->name('admin');

Route::get('/{facultyName}.html', 'Front\HomeController@faculty')->name('front.faculty');
Route::post('/{facultyName}/{childSlug}', 'Front\HomeController@childMessage')->name('front.child.message');
Route::get('/{facultyName}/{childSlug}.html', 'Front\HomeController@child')->name('front.child');
