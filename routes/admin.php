<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return redirect('/admin/login'); })->name('home');
Auth::routes();
Route::get('/email/activation/{token}', 'Auth\ActivateEmailController@activate')->name('email.activate');

Route::get('/blank', 'DashboardController@blank')->name('blank');
Route::get('/manual', 'DashboardController@manual')->name('manual');
Route::get('/test', 'DashboardController@test');
Route::get('/materials', 'DashboardController@materials')->name('materials');
Route::get('/form/create', 'DashboardController@createForm')->name('form.create');
Route::post('/form', 'DashboardController@storeForm')->name('form.store');

Route::prefix('vote')->group(function () {
  Route::get('/', 'DashboardController@vote')->name('vote');
  Route::post('/','DashboardController@voteStore')->name('vote.store');
});

Route::prefix('dashboard')->group(function () {
  Route::get('/', 'DashboardController@dashboard')->name('dashboard');
  Route::get('/count', 'DashboardController@count')->name('dashboard.count');
  Route::get('/data', 'DashboardController@data')->name('dashboard.data');
});


Route::prefix('statistic')->as('statistics.')->group(function () {
  Route::get('volunteer', 'StatisticController@volunteer')->name('volunteer');
  Route::get('volunteer/messages', 'StatisticController@volunteersAndMessages')->name('volunteer.messages');

  Route::get('faculty', 'StatisticController@faculty')->name('faculty');

  Route::get('social/facebook', 'StatisticController@facebook')->name('facebook');
  Route::get('social/facebook/{id}', 'StatisticController@facebookPost')->name('facebook.post');

  Route::prefix('website')->group(function () {
    Route::get('/', 'StatisticController@website')->name('website');
    Route::get('/visitors', 'StatisticController@websiteVisitors')->name('website.visitors');
    Route::get('/active', 'StatisticController@websiteActive')->name('website.active');
  });


  Route::get('child', 'StatisticController@child')->name('child');
  Route::get('child/department', 'StatisticController@childDepartment' )->name('child.department');

  Route::prefix('blood')->group(function () {
    Route::get('/', 'StatisticController@blood')->name('blood');
    Route::get('/rh', 'StatisticController@bloodRh' )->name('blood.rh');
    Route::get('/type', 'StatisticController@bloodType' )->name('blood.type');
  });


  Route::get('user', 'StatisticController@user')->name('user');
  Route::get('user/horoscope', 'StatisticController@userHoroscope' )->name('user.horoscope');

  Route::get('children/count/general', 'StatisticController@children_by_general')->name('children.count.general');
  Route::get('children/count/faculty/{id}', 'StatisticController@children_by_faculty')->name('children.count.faculty');
});

Route::resource('emailsample', 'EmailSampleController');

Route::prefix('post')->as('post.')->group(function () {
  Route::get('/data', 'PostController@indexData')->name('index.data');
  Route::get('unapprovedCount', 'PostController@unapprovedCount')->name('unapprovedCount');
  Route::post('approve', 'PostController@approve')->name('approve');
});
Route::resource('post', 'PostController');


Route::prefix('user')->as('user.')->group(function () {
  Route::prefix('{id}')->group(function () {
    Route::get('children', 'UserController@children')->name('children');
    Route::get('children/data', 'UserController@childrenData')->name('children.data');
  });
  Route::get('/data', 'UserController@indexData')->name('index.data');
  Route::post('approve', 'UserController@approve')->name('approve');
});
Route::resource('user', 'UserController');

Route::prefix('child')->as('child.')->group(function () {
  Route::get('/data', 'ChildController@indexData')->name('index.data');
  Route::prefix('{id}')->group(function () {
    Route::put('volunteer', 'ChildController@volunteered')->name('volunteered');
    Route::get('chats', 'ChildController@chats')->name('chats');
    Route::get('chat/{chatID}', 'ChildController@chat')->name('chat');
    Route::get('chats/opens', 'ChildController@chatsOpens')->name('chats.opens');
  });

});
Route::resource('child', 'ChildController');
Route::resource('diagnosis', 'DiagnosisController');

Route::prefix('faculty')->as('faculty.')->group(function () {
  Route::prefix('{id}')->group(function () {
    Route::get('messages', 'FacultyController@messages')->name('messages');
    Route::get('messages/unanswered', 'FacultyController@messagesUnanswered')->name('messages.unanswered');
    Route::get('children', 'FacultyController@children')->name('children');
    Route::get('children/data', 'FacultyController@childrenData')->name('children.data');
    Route::get('posts', 'FacultyController@posts')->name('posts');
    Route::get('posts/data', 'FacultyController@postsData')->name('posts.data');
    Route::get('posts/unapproved', 'FacultyController@postsUnapproved')->name('posts.unapproved');
    Route::get('posts/unapproved/data', 'FacultyController@postsUnapprovedData')->name('posts.unapproved.data');
    Route::get('posts/unapproved/count', 'FacultyController@postsUnapprovedCount')->name('posts.unapproved.count');
    Route::get('profiles', 'FacultyController@profiles')->name('profiles');
    Route::get('users', 'FacultyController@users')->name('users');
    Route::get('users/data', 'FacultyController@usersData')->name('users.data');
    Route::get('users/unapproved', 'FacultyController@unapproved')->name('users.unapproved');
    Route::get('users/unapproved/data', 'FacultyController@unapprovedData')->name('users.unapproved.data');
    Route::get('users/unapproved/count', 'FacultyController@unapprovedCount')->name('users.unapproved.count');
    Route::get('sendmail', 'FacultyController@createMail')->name('mail.create');
    Route::post('sendmail', 'FacultyController@sendMail')->name('mail.send');
  });
  Route::get('cities', 'FacultyController@cities')->name('cities');
  Route::get('city/{code}', 'FacultyController@city')->name('city');
});
Route::resource('faculty', 'FacultyController');

Route::prefix('chat')->as('chat.')->group(function () {
  Route::prefix('{id}')->group(function () {
    Route::put('close', 'ChatController@close')->name('close');
  });
});
Route::resource('chat', 'ChatController');

Route::prefix('message')->as('message.')->group(function () {
  Route::prefix('{id}')->group(function () {
    Route::put('answered', 'MessageController@answered')->name('answered');
  });
});
Route::resource('message', 'MessageController');


Route::prefix('volunteer')->as('volunteer.')->group(function () {
  Route::get('unanswered', 'VolunteerController@unanswered')->name('unanswered');
  Route::post('unanswered', 'VolunteerController@childUnanswered')->name('unanswered');
  Route::get('data', 'VolunteerController@indexData')->name('index.data');
});
Route::resource('volunteer', 'VolunteerController');

Route::post('/process', 'ChildController@createProcess')->name('process.store');

Route::prefix('blood')->as('blood.')->group(function () {
  Route::get('/people', 'BloodController@editPeople')->name('people.edit');
  Route::post('/people', 'BloodController@updatePeople')->name('people.update');
  Route::get('/data', 'BloodController@indexData')->name('index.data');
  Route::get('/sms', 'BloodController@showSMS')->name('sms.show');
  Route::get('/sms/balance', 'BloodController@checkBalance')->name('sms.balance');
  Route::post('/sms/preview', 'BloodController@previewSMS')->name('sms.preview');
  Route::post('/sms/test', 'BloodController@testSMS')->name('sms.test');
  Route::post('/sms', 'BloodController@sendSMS')->name('sms.send');
});
Route::resource('blood', 'BloodController');

Route::prefix('new')->as('new.')->group(function () {
  Route::get('/channel', 'NewController@channelsData')->name('channels.data');
});
Route::resource('new', 'NewController');

Route::resource('sponsor', 'SponsorController');

Route::prefix('testimonial')->as('testimonial.')->group(function () {
  Route::get('/data', 'TestimonialController@indexData')->name('index.data');
});
Route::resource('testimonial', 'TestimonialController');

Route::resource('mobile-notification', 'MobileNotificationController');
Route::post('mobile-notification/{id}/send', 'MobileNotificationController@send')->name('mobile-notification.send');

Route::resource('blog', 'BlogController');

Route::prefix('log')->middleware('auth')->group(function() {
  Route::get('/', [ 'as'        => 'log-viewer::dashboard', 'uses'   => 'LogController@index',]);
  Route::get('/lists', [ 'as'   => 'log-viewer::logs.list', 'uses'   => 'LogController@listLogs',]);
  Route::delete('delete', ['as' => 'log-viewer::logs.delete', 'uses' => 'LogController@delete',]);
  Route::group([ 'prefix'    => '{date}',], function() {
    Route::get('/', ['as'        => 'log-viewer::logs.show', 'uses'     => 'LogController@show',]);
    Route::get('download', ['as' => 'log-viewer::logs.download', 'uses' => 'LogController@download',]);
    Route::get('{level}', ['as'  => 'log-viewer::logs.filter', 'uses'   => 'LogController@showByLevel',]);
  });
});
