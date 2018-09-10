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

Route::prefix('vote')->group(function () {
    Route::get('/', 'Admin\Miscellaneous\DashboardController@vote')->name('vote');
    Route::post('/', 'Admin\Miscellaneous\DashboardController@voteStore')->name('vote.store');
});

Route::prefix('statistic')->as('statistics.')->group(function () {
    Route::get('volunteer', 'Admin\Miscellaneous\StatisticController@volunteer')->name('volunteer');
    Route::get('volunteer/messages', 'Admin\Miscellaneous\StatisticController@volunteersAndMessages')
         ->name('volunteer.messages');

    Route::get('faculty', 'Admin\Miscellaneous\StatisticController@faculty')->name('faculty');

    Route::get('social/facebook', 'Admin\Miscellaneous\StatisticController@facebook')->name('facebook');
    Route::get('social/facebook/{id}', 'Admin\Miscellaneous\StatisticController@facebookPost')->name('facebook.post');

    Route::prefix('website')->group(function () {
        Route::get('/', 'Admin\Miscellaneous\StatisticController@website')->name('website');
        Route::get('/visitors', 'Admin\Miscellaneous\StatisticController@websiteVisitors')->name('website.visitors');
        Route::get('/active', 'Admin\Miscellaneous\StatisticController@websiteActive')->name('website.active');
    });

    Route::get('child', 'Admin\Miscellaneous\StatisticController@child')->name('child');
    Route::get('child/department', 'Admin\Miscellaneous\StatisticController@childDepartment')->name('child.department');

    Route::prefix('blood')->group(function () {
        Route::get('/', 'Admin\Miscellaneous\StatisticController@blood')->name('blood');
        Route::get('/rh', 'Admin\Miscellaneous\StatisticController@bloodRh')->name('blood.rh');
        Route::get('/type', 'Admin\Miscellaneous\StatisticController@bloodType')->name('blood.type');
    });

    Route::get('user', 'Admin\Miscellaneous\StatisticController@user')->name('user');
    Route::get('user/horoscope', 'Admin\Miscellaneous\StatisticController@userHoroscope')->name('user.horoscope');

    Route::get('children/count/general', 'Admin\Miscellaneous\StatisticController@children_by_general')
         ->name('children.count.general');
    Route::get('children/count/faculty/{id}', 'Admin\Miscellaneous\StatisticController@children_by_faculty')
         ->name('children.count.faculty');
});

Route::prefix('child')->as('child.')->group(function () {
    Route::get('/data', 'Admin\Child\ChildController@indexData')->name('index.data');
    Route::prefix('{id}')->group(function () {
        Route::put('volunteer', 'Admin\Child\ChildController@volunteered')->name('volunteered');
        Route::get('chats', 'Admin\Child\ChildController@chats')->name('chats');
        Route::get('chat/{chatID}', 'Admin\Child\ChildController@chat')->name('chat');
        Route::get('chats/opens', 'Admin\Child\ChildController@chatsOpens')->name('chats.opens');
    });
});

Route::prefix('faculty')->as('faculty.')->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::get('messages', 'Admin\Management\FacultyController@messages')->name('messages');
        Route::get('messages/unanswered', 'Admin\Management\FacultyController@messagesUnanswered')
             ->name('messages.unanswered');
        Route::get('children', 'Admin\Management\FacultyController@children')->name('children');
        Route::get('children/data', 'Admin\Management\FacultyController@childrenData')->name('children.data');
        Route::get('posts', 'Admin\Management\FacultyController@posts')->name('posts');
        Route::get('posts/data', 'Admin\Management\FacultyController@postsData')->name('posts.data');
        Route::get('posts/unapproved', 'Admin\Management\FacultyController@postsUnapproved')->name('posts.unapproved');
        Route::get('posts/unapproved/data', 'Admin\Management\FacultyController@postsUnapprovedData')
             ->name('posts.unapproved.data');
        Route::get('posts/unapproved/count', 'Admin\Management\FacultyController@postsUnapprovedCount')
             ->name('posts.unapproved.count');
        Route::get('profiles', 'Admin\Management\FacultyController@profiles')->name('profiles');
        Route::get('sendmail', 'Admin\Management\FacultyController@createMail')->name('mail.create');
        Route::post('sendmail', 'Admin\Management\FacultyController@sendMail')->name('mail.send');
    });
});
Route::resource('faculty', 'Admin\Management\FacultyController');

Route::prefix('chat')->as('chat.')->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::put('close', 'Admin\Volunteer\ChatController@close')->name('close');
    });
});
Route::resource('chat', 'Admin\Volunteer\ChatController');

Route::prefix('message')->as('message.')->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::put('answered', 'Admin\Volunteer\MessageController@answered')->name('answered');
    });
});
Route::resource('message', 'Admin\Volunteer\MessageController');

Route::prefix('volunteer')->as('volunteer.')->group(function () {
    Route::get('unanswered', 'Admin\Volunteer\VolunteerController@unanswered')->name('unanswered');
    Route::post('unanswered', 'Admin\Volunteer\VolunteerController@childUnanswered')->name('unanswered');
    Route::get('data', 'Admin\Volunteer\VolunteerController@indexData')->name('index.data');
});
Route::resource('volunteer', 'Admin\Volunteer\VolunteerController');

Route::post('/process', 'Admin\Child\ChildController@createProcess')->name('process.store');

Route::resource('mobile-notification', 'Admin\Volunteer\MobileNotificationController');
Route::post('mobile-notification/{id}/send', 'Admin\Volunteer\MobileNotificationController@send')
     ->name('mobile-notification.send');

Route::resource('blog', 'Admin\Content\BlogController');

/*
|--------------------------------------------------------------------------
| Refactored Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/admin/login');
})->name('home');

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'Admin\Miscellaneous\DashboardController@index')->name('dashboard');
    Route::get('/data', 'Admin\Miscellaneous\DashboardController@data')->name('dashboard.data');
});

Route::get('sidebar/data', 'Admin\Miscellaneous\SidebarController@data')->name('sidebar.data');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
// TODO: Uncomment on Laravel 5.7
//Route::prefix('email')->as('verification.')->group(function () {
//    Route::get('resend', 'Admin\Auth\VerificationController@resend')->name('resend');
//    Route::get('verify', 'Admin\Auth\VerificationController@show')->name('notice');
//    Route::get('verify/{id}', 'Admin\Auth\VerificationController@verify')->name('verify');
//});
Route::prefix('password')->as('password.')->group(function () {
    Route::post('email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('email');
    Route::get('reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('request');
    Route::post('reset', 'Admin\Auth\ResetPasswordController@reset')->name('update');
    Route::get('reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('reset');
});
Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Admin\Auth\LoginController@login')->name('login.post');
Route::post('logout', 'Admin\Auth\LoginController@logout')->name('logout');
Route::get('register', 'Admin\Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('register', 'Admin\Auth\RegisterController@register')->name('register.post');

Route::get('/email/activation/{token}', 'Admin\Auth\ActivateEmailController@activate')->name('email.activate');

/*
|--------------------------------------------------------------------------
| Children Routes
|--------------------------------------------------------------------------
*/
Route::resource('child', 'Admin\Child\ChildController');

/*
|--------------------------------------------------------------------------
| Post Routes
|--------------------------------------------------------------------------
*/
Route::approve('post', 'Admin\Child\PostController');
Route::resource('post', 'Admin\Child\PostController');

/*
|--------------------------------------------------------------------------
| Faculty Routes
|--------------------------------------------------------------------------
*/
Route::prefix('faculty')->as('faculty.')->group(function () {
    Route::prefix('{faculty}')->group(function () {
        Route::get('post', 'Admin\Child\PostController@faculty')->name('post');
        Route::resource('email', 'Admin\Management\FacultyEmailController')->only(['create', 'store']);
        Route::resource('user', 'Admin\Management\FacultyUserController')->parameters([
            'user' => 'any_user'
        ]);
    });
});
Route::resource('faculty', 'Admin\Management\FacultyController');

Route::get('/form/create', 'Admin\Miscellaneous\FormController@create')->name('form.create');
Route::post('/form', 'Admin\Miscellaneous\FormController@store')->name('form.store');

// Route::get('users/data', 'Admin\Management\FacultyController@usersData')->name('users.data');
// Route::get('users/unapproved', 'Admin\Management\FacultyController@unapproved')->name('users.unapproved');
// Route::get('users/unapproved/data', 'Admin\Management\FacultyController@unapprovedData')->name('users.unapproved.data');
// Route::get('users/unapproved/count', 'Admin\Management\FacultyController@unapprovedCount')->name('users.unapproved.count');

/*
|--------------------------------------------------------------------------
| Blood Routes
|--------------------------------------------------------------------------
*/
Route::prefix('blood')->as('blood.')->group(function () {
    Route::get('/people', 'Admin\Blood\BloodUserController@edit')->name('people.edit');
    Route::post('/people', 'Admin\Blood\BloodUserController@update')->name('people.update');
    Route::get('/sms', 'Admin\Blood\SmsController@index')->name('sms.index');
    Route::get('/sms/send', 'Admin\Blood\SmsController@show')->name('sms.show');
    Route::post('/sms/send', 'Admin\Blood\SmsController@send')->name('sms.send');
    Route::get('/sms/balance', 'Admin\Blood\SmsController@checkBalance')->name('sms.balance');
    Route::post('/sms/preview', 'Admin\Blood\SmsController@preview')->name('sms.preview');
    Route::post('/sms/test', 'Admin\Blood\SmsController@test')->name('sms.test');
});
Route::resource('blood', 'Admin\Blood\BloodController');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::approve('user', 'Admin\Management\UserController');
Route::prefix('user')->as('user.')->group(function () {
    Route::prefix('{user}')->group(function () {
        Route::get('children', 'Admin\Management\UserController@children')->name('children');
        Route::get('children/data', 'Admin\Management\UserController@childrenData')->name('children.data');
    });
});
Route::resource('user', 'Admin\Management\UserController')->parameters([
    'user' => 'any_user'
]);

/*
|--------------------------------------------------------------------------
| General Setting Routes
|--------------------------------------------------------------------------
*/
Route::resource('diagnosis', 'Admin\Child\DiagnosisController');
Route::resource('department', 'Admin\Child\DepartmentController');

/*
|--------------------------------------------------------------------------
| Content Routes
|--------------------------------------------------------------------------
*/
Route::resource('new', 'Admin\Content\NewController');
Route::resource('channel', 'Admin\Content\ChannelController');
Route::resource('sponsor', 'Admin\Content\SponsorController');
Route::resource('question', 'Admin\Content\QuestionController');
Route::approve('testimonial', 'Admin\Content\TestimonialController');
Route::resource('testimonial', 'Admin\Content\TestimonialController');

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/
Route::resource('emailsample', 'Admin\Resource\EmailSampleController');
Route::resource('material', 'Admin\Resource\MaterialController');
Route::resource('tutorial', 'Admin\Resource\TutorialController');