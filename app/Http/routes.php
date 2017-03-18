<?php

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('log', 'ApiAdminController@log')->name('api.admin.logs');
        Route::get('log/{date}', 'ApiAdminController@logDaily')->name('api.admin.logs.daily');
    });

    Route::get('children', 'ApiController@children')->name('api.children');
    Route::get('child/{id}', 'ApiController@child')->name('api.child');
    Route::post('child/form', 'ApiController@childForm')->name('api.child.form');
    Route::post('token', 'ApiController@token')->name('api.token');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => ['web']], function () {
    Route::get('/yonetim', function () { return redirect('/admin/login'); });
    Route::group(['prefix' => 'admin'], function () {
        Route::auth();
        Route::get('/', function () { return redirect('/admin/login'); })->name('admin.login');
        Route::get('/blank', 'DashboardController@blank')->name('admin.blank');
        Route::get('/sendemail', 'DashboardController@sendEmail');
        Route::get('/test', 'DashboardController@test');
        Route::get('/moving', 'DashboardController@moving');
        Route::get('/materials', 'DashboardController@materials')->name('admin.materials');
        Route::get('/form/create', 'DashboardController@createForm')->name('admin.form.create');
        Route::post('/form', 'DashboardController@storeForm')->name('admin.form.store');


        Route::get('/manual', 'DashboardController@manual')->name('admin.manual');

        Route::group(['prefix' => 'oylama'], function () {
            Route::get('/', 'DashboardController@oylama')->name('admin.oylama');
            Route::post('/','DashboardController@oylamaKaydet')->name('admin.oylama.kaydet');
        });

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard');
            Route::get('birthdays','DashboardController@birthdays')->name('admin.dashboard.birthdays');
        });

        Route::group(['prefix' => 'statistics'], function () {
            Route::get('volunteer', 'StatisticController@volunteer')->name('admin.statistics.volunteer');
            Route::get('volunteer/messages', 'StatisticController@volunteersAndMessages')->name('admin.statistics.volunteer.messages');

            Route::get('faculty', 'StatisticController@faculty')->name('admin.statistics.faculty');

            Route::get('social/facebook', 'StatisticController@facebook')->name('admin.statistics.facebook');
            Route::get('social/facebook/{id}', 'StatisticController@facebookPost')->name('admin.statistics.facebook.post');


            Route::get('website', 'StatisticController@website')->name('admin.statistics.website');
            Route::get('website/visitors', 'StatisticController@websiteVisitors')->name('admin.statistics.website.visitors');
            Route::get('website/active', 'StatisticController@websiteActive')->name('admin.statistics.website.active');

            Route::get('child', 'StatisticController@child')->name('admin.statistics.child');
            Route::get('child/department', 'StatisticController@childDepartment' )->name('admin.statistics.child.department');

            Route::get('blood', 'StatisticController@blood')->name('admin.statistics.blood');
            Route::get('blood/rh', 'StatisticController@bloodRh' )->name('admin.statistics.blood.rh');
            Route::get('blood/type', 'StatisticController@bloodType' )->name('admin.statistics.blood.type');
            Route::get('blood/gender', 'StatisticController@bloodGender' )->name('admin.statistics.blood.gender');

            Route::get('user', 'StatisticController@user')->name('admin.statistics.user');
            Route::get('user/horoscope', 'StatisticController@userHoroscope' )->name('admin.statistics.user.horoscope');
            Route::get('children/count/general', 'StatisticController@children_by_general')->name('admin.statistics.children.count.general');
            Route::get('children/count/faculty/{id}', 'StatisticController@children_by_faculty')->name('admin.statistics.children.count.faculty');
        });

        Route::group(['prefix' => 'post'], function () {
            Route::get('/data', 'PostController@indexData')->name('admin.post.index.data');
            Route::get('unapprovedCount', 'PostController@unapprovedCount')->name('admin.post.unapprovedCount');
            Route::post('approve', 'PostController@approve')->name('admin.post.approve');
        });
        Route::resource('post', 'PostController');





        Route::group(['prefix' => 'user'], function () {
            Route::group(['prefix' => '{id}'], function () {
                Route::get('children', 'UserController@children')->name('admin.user.children');
                Route::get('children/data', 'UserController@childrenData')->name('admin.user.children.data');
            });
            Route::get('/data', 'UserController@indexData')->name('admin.user.index.data');
            Route::post('approve', 'UserController@approve')->name('admin.user.approve');
        });
        Route::resource('user', 'UserController');


        Route::group(['prefix' => 'child'], function () {
            Route::get('/data', 'ChildController@indexData')->name('admin.child.index.data');
            Route::group(['prefix' => '{id}'], function () {
                Route::put('volunteer', 'ChildController@volunteered')->name('admin.children.volunteered');
                Route::get('chats', 'ChildController@chats')->name('admin.children.chats');
                Route::get('chat/{chatID}', 'ChildController@chat')->name('admin.children.chat');
                Route::get('chats/opens', 'ChildController@chatsOpens')->name('admin.children.chats.opens');
            });

        });
        Route::resource('child', 'ChildController');

        Route::group(['prefix' => 'faculty'], function () {
            Route::group(['prefix' => '{id}'], function () {
                Route::get('messages', 'FacultyController@messages')->name('admin.faculty.messages');
                Route::get('messages/unanswered', 'FacultyController@messagesUnanswered')->name('admin.faculty.messages.unanswered');

                Route::get('children', 'FacultyController@children')->name('admin.faculty.children');
                Route::get('children/data', 'FacultyController@childrenData')->name('admin.faculty.children.data');
                Route::get('posts', 'FacultyController@posts')->name('admin.faculty.posts');
                Route::get('posts/data', 'FacultyController@postsData')->name('admin.faculty.posts.data');
                Route::get('posts/unapproved', 'FacultyController@postsUnapproved')->name('admin.faculty.posts.unapproved');
                Route::get('posts/unapproved/data', 'FacultyController@postsUnapprovedData')->name('admin.faculty.posts.unapproved.data');
                Route::get('posts/unapproved/count', 'FacultyController@postsUnapprovedCount')->name('admin.faculty.posts.unapproved.count');
                Route::get('profiles', 'FacultyController@profiles')->name('admin.faculty.profiles');
                Route::get('users', 'FacultyController@users')->name('admin.faculty.users');
                Route::get('users/data', 'FacultyController@usersData')->name('admin.faculty.users.data');
                Route::get('users/unapproved', 'FacultyController@unapproved')->name('admin.faculty.users.unapproved');
                Route::get('users/unapproved/data', 'FacultyController@unapprovedData')->name('admin.faculty.users.unapproved.data');
                Route::get('users/unapproved/count', 'FacultyController@unapprovedCount')->name('admin.faculty.users.unapproved.count');
                Route::get('sendmail', 'FacultyController@createMail')->name('admin.faculty.mail.create');
                Route::post('sendmail', 'FacultyController@sendMail')->name('admin.faculty.mail.send');


            });
            Route::get('cities', 'FacultyController@cities')->name('admin.faculty.cities');
            Route::get('city/{code}', 'FacultyController@city')->name('admin.faculty.city');
        });
        Route::resource('faculty', 'FacultyController');


        Route::group(['prefix' => 'chat'], function () {
            Route::group(['prefix' => '{id}'], function () {
                Route::put('close', 'ChatController@close')->name('admin.chat.close');
            });
        });
        Route::resource('chat', 'ChatController');


        Route::group(['prefix' => 'message'], function () {
            Route::group(['prefix' => '{id}'], function () {
                Route::put('answered', 'MessageController@answered')->name('admin.message.answered');
            });
        });
        Route::resource('message', 'MessageController');


        Route::group(['prefix' => 'volunteer'], function () {
            Route::get('unanswered', 'VolunteerController@unanswered')->name('admin.volunteer.unanswered');
            Route::post('unanswered', 'VolunteerController@childUnanswered')->name('admin.volunteer.unanswered');
            Route::get('data', 'VolunteerController@indexData')->name('admin.volunteer.index.data');
        });
        Route::resource('volunteer', 'VolunteerController');


        Route::group(['prefix' => 'social'], function () {
            Route::get('unpublished', 'SocialController@unpublished')->name('admin.social.unpublished');
            Route::post('all', 'SocialController@index')->name('admin.social.published');
        });
        Route::resource('social', 'SocialController');



        Route::post('/process', 'ChildController@createProcess')->name('admin.process.store');


        Route::group(['prefix' => 'blood'], function () {
            Route::get('/data', 'BloodController@indexData')->name('admin.blood.index.data');
            Route::get('/sms', 'BloodController@showSMS')->name('admin.blood.sms.show');
            Route::post('/sms/preview', 'BloodController@previewSMS')->name('admin.blood.sms.preview');
            Route::post('/sms/test', 'BloodController@testSMS')->name('admin.blood.sms.test');
            Route::post('/sms', 'BloodController@sendSMS')->name('admin.blood.sms.send');
        });

        Route::resource('blood', 'BloodController');

        Route::group(['prefix' => 'new'], function () {
            Route::get('/channels', 'NewController@channelsData')->name('admin.new.channels.data');
        });

        Route::resource('blog', 'BlogController');
        Route::resource('new', 'NewController');

        Route::group(['prefix' => 'testimonial'], function () {
            Route::get('/data', 'TestimonialController@indexData')->name('admin.testimonial.index.data');
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
    Route::get('/neler-soylediniz.html', 'FrontController@testimonials')->name('front.testimonials');
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

});
