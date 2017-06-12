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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Auth::routes();
    Route::get('/email/activation/{token}', 'Auth\ActivateEmailController@activate')->name('email.activate');
    Route::get('/', function () { return redirect('/admin/login'); })->name('home');
    Route::get('/blank', 'DashboardController@blank')->name('blank');
    Route::get('/sendemail', 'DashboardController@sendEmail');
    Route::get('/test', 'DashboardController@test');
    Route::get('/moving', 'DashboardController@moving');
    Route::get('/materials', 'DashboardController@materials')->name('materials');
    Route::get('/form/create', 'DashboardController@createForm')->name('form.create');
    Route::post('/form', 'DashboardController@storeForm')->name('form.store');


    Route::get('/manual', 'DashboardController@manual')->name('manual');

    Route::group(['prefix' => 'oylama'], function () {
        Route::get('/', 'DashboardController@oylama')->name('oylama');
        Route::post('/','DashboardController@oylamaKaydet')->name('oylama.kaydet');
    });

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
        Route::get('birthdays','DashboardController@birthdays')->name('dashboard.birthdays');
    });

    Route::group(['prefix' => 'statistics'], function () {
        Route::get('volunteer', 'StatisticController@volunteer')->name('statistics.volunteer');
        Route::get('volunteer/messages', 'StatisticController@volunteersAndMessages')->name('statistics.volunteer.messages');

        Route::get('faculty', 'StatisticController@faculty')->name('statistics.faculty');

        Route::get('social/facebook', 'StatisticController@facebook')->name('statistics.facebook');
        Route::get('social/facebook/{id}', 'StatisticController@facebookPost')->name('statistics.facebook.post');


        Route::get('website', 'StatisticController@website')->name('statistics.website');
        Route::get('website/visitors', 'StatisticController@websiteVisitors')->name('statistics.website.visitors');
        Route::get('website/active', 'StatisticController@websiteActive')->name('statistics.website.active');

        Route::get('child', 'StatisticController@child')->name('statistics.child');
        Route::get('child/department', 'StatisticController@childDepartment' )->name('statistics.child.department');

        Route::get('blood', 'StatisticController@blood')->name('statistics.blood');
        Route::get('blood/rh', 'StatisticController@bloodRh' )->name('statistics.blood.rh');
        Route::get('blood/type', 'StatisticController@bloodType' )->name('statistics.blood.type');

        Route::get('user', 'StatisticController@user')->name('statistics.user');
        Route::get('user/horoscope', 'StatisticController@userHoroscope' )->name('statistics.user.horoscope');
        Route::get('children/count/general', 'StatisticController@children_by_general')->name('statistics.children.count.general');
        Route::get('children/count/faculty/{id}', 'StatisticController@children_by_faculty')->name('statistics.children.count.faculty');
    });

    Route::group(['prefix' => 'post'], function () {
        Route::get('/data', 'PostController@indexData')->name('post.index.data');
        Route::get('unapprovedCount', 'PostController@unapprovedCount')->name('post.unapprovedCount');
        Route::post('approve', 'PostController@approve')->name('post.approve');
    });
    Route::resource('post', 'PostController');





    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => '{id}'], function () {
            Route::get('children', 'UserController@children')->name('user.children');
            Route::get('children/data', 'UserController@childrenData')->name('user.children.data');
        });
        Route::get('/data', 'UserController@indexData')->name('user.index.data');
        Route::post('approve', 'UserController@approve')->name('user.approve');
    });
    Route::resource('user', 'UserController');


    Route::group(['prefix' => 'child'], function () {
        Route::get('/data', 'ChildController@indexData')->name('child.index.data');
        Route::group(['prefix' => '{id}'], function () {
            Route::put('volunteer', 'ChildController@volunteered')->name('children.volunteered');
            Route::get('chats', 'ChildController@chats')->name('children.chats');
            Route::get('chat/{chatID}', 'ChildController@chat')->name('children.chat');
            Route::get('chats/opens', 'ChildController@chatsOpens')->name('children.chats.opens');
        });

    });
    Route::resource('child', 'ChildController');
    Route::resource('diagnosis', 'DiagnosisController');

    Route::group(['prefix' => 'faculty'], function () {
        Route::group(['prefix' => '{id}'], function () {
            Route::get('messages', 'FacultyController@messages')->name('faculty.messages');
            Route::get('messages/unanswered', 'FacultyController@messagesUnanswered')->name('faculty.messages.unanswered');

            Route::get('children', 'FacultyController@children')->name('faculty.children');
            Route::get('children/data', 'FacultyController@childrenData')->name('faculty.children.data');
            Route::get('posts', 'FacultyController@posts')->name('faculty.posts');
            Route::get('posts/data', 'FacultyController@postsData')->name('faculty.posts.data');
            Route::get('posts/unapproved', 'FacultyController@postsUnapproved')->name('faculty.posts.unapproved');
            Route::get('posts/unapproved/data', 'FacultyController@postsUnapprovedData')->name('faculty.posts.unapproved.data');
            Route::get('posts/unapproved/count', 'FacultyController@postsUnapprovedCount')->name('faculty.posts.unapproved.count');
            Route::get('profiles', 'FacultyController@profiles')->name('faculty.profiles');
            Route::get('users', 'FacultyController@users')->name('faculty.users');
            Route::get('users/data', 'FacultyController@usersData')->name('faculty.users.data');
            Route::get('users/unapproved', 'FacultyController@unapproved')->name('faculty.users.unapproved');
            Route::get('users/unapproved/data', 'FacultyController@unapprovedData')->name('faculty.users.unapproved.data');
            Route::get('users/unapproved/count', 'FacultyController@unapprovedCount')->name('faculty.users.unapproved.count');
            Route::get('sendmail', 'FacultyController@createMail')->name('faculty.mail.create');
            Route::post('sendmail', 'FacultyController@sendMail')->name('faculty.mail.send');


        });
        Route::get('cities', 'FacultyController@cities')->name('faculty.cities');
        Route::get('city/{code}', 'FacultyController@city')->name('faculty.city');
    });
    Route::resource('faculty', 'FacultyController');


    Route::group(['prefix' => 'chat'], function () {
        Route::group(['prefix' => '{id}'], function () {
            Route::put('close', 'ChatController@close')->name('chat.close');
        });
    });
    Route::resource('chat', 'ChatController');


    Route::group(['prefix' => 'message'], function () {
        Route::group(['prefix' => '{id}'], function () {
            Route::put('answered', 'MessageController@answered')->name('message.answered');
        });
    });
    Route::resource('message', 'MessageController');


    Route::group(['prefix' => 'volunteer'], function () {
        Route::get('unanswered', 'VolunteerController@unanswered')->name('volunteer.unanswered');
        Route::post('unanswered', 'VolunteerController@childUnanswered')->name('volunteer.unanswered');
        Route::get('data', 'VolunteerController@indexData')->name('volunteer.index.data');
    });
    Route::resource('volunteer', 'VolunteerController');


    Route::group(['prefix' => 'social'], function () {
        Route::get('unpublished', 'SocialController@unpublished')->name('social.unpublished');
        Route::post('all', 'SocialController@index')->name('social.published');
    });
    Route::resource('social', 'SocialController');



    Route::post('/process', 'ChildController@createProcess')->name('process.store');


    Route::group(['prefix' => 'blood'], function () {
        Route::get('/people', 'BloodController@editPeople')->name('blood.people.edit');
        Route::post('/people', 'BloodController@updatePeople')->name('blood.people.update');
        Route::get('/data', 'BloodController@indexData')->name('blood.index.data');
        Route::get('/sms', 'BloodController@showSMS')->name('blood.sms.show');
        Route::get('/sms/balance', 'BloodController@checkBalance')->name('blood.sms.balance');
        Route::post('/sms/preview', 'BloodController@previewSMS')->name('blood.sms.preview');
        Route::post('/sms/test', 'BloodController@testSMS')->name('blood.sms.test');
        Route::post('/sms', 'BloodController@sendSMS')->name('blood.sms.send');
    });
    Route::resource('blood', 'BloodController');

    Route::group(['prefix' => 'new'], function () {
        Route::get('/channels', 'NewController@channelsData')->name('new.channels.data');
    });

    Route::resource('blog', 'BlogController');
    Route::resource('new', 'NewController');
    Route::resource('sponsor', 'SponsorController');

    Route::group(['prefix' => 'testimonial'], function () {
        Route::get('/data', 'TestimonialController@indexData')->name('testimonial.index.data');
    });

    Route::resource('testimonial', 'TestimonialController');
    Route::resource('emailsample', 'EmailSampleController');
    Route::resource('mobile-notification', 'MobileNotificationController');
    Route::post('mobile-notification/{id}/send', 'MobileNotificationController@send')->name('mobile-notification.send');



    Route::group([ 'prefix' => 'logs', 'middleware' => ['auth']], function() {
        Route::get('/', [ 'as'    => 'log-viewer::dashboard',  'uses'  => 'LogController@index',]);
        Route::get('/lists', [ 'as'    => 'log-viewer::logs.list',  'uses'  => 'LogController@listLogs',]);
        Route::delete('delete', ['as'    => 'log-viewer::logs.delete', 'uses'  => 'LogController@delete',]);
        Route::group([ 'prefix'    => '{date}',], function() {
            Route::get('/', ['as'    => 'log-viewer::logs.show', 'uses'  => 'LogController@show',]);
            Route::get('download', ['as'    => 'log-viewer::logs.download', 'uses'  => 'LogController@download',]);
            Route::get('{level}', ['as'    => 'log-viewer::logs.filter', 'uses'  => 'LogController@showByLevel',]);
        });
    });

});


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

Route::get('/{facultyName}.html', 'FrontController@faculty')->name('front.faculty');
Route::post('/{facultyName}/{childSlug}', 'FrontController@childMessage')->name('front.child.message');
Route::get('/{facultyName}/{childSlug}.html', 'FrontController@child')->name('front.child');
