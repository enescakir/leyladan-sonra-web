<?php

Route::group(['prefix' => 'api'], function () {
    Route::get('children', 'ApiController@children')->name('api.children');
    Route::get('child/{id}', 'ApiController@child')->name('api.child');

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
        Route::get('/moving', 'DashboardController@moving');
        Route::get('/materials', 'DashboardController@materials')->name('admin.materials');


        Route::get('/kilavuz', 'DashboardController@manual')->name('admin.manual');

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard');
            Route::get('birthdays','DashboardController@birthdays')->name('admin.dashboard.birthdays');
        });

        Route::group(['prefix' => 'statics'], function () {
            Route::get('user', 'StaticController@user')->name('admin.statics.user');
            Route::get('horoscope', 'StaticController@horoscope' )->name('admin.statics.horoscope');
            Route::get('children/count/general', 'StaticController@children_by_general')->name('admin.statics.children.count.general');
            Route::get('children/count/faculty/{id}', 'StaticController@children_by_faculty')->name('admin.statics.children.count.faculty');
        });

        Route::group(['prefix' => 'post'], function () {
            Route::get('/data', 'PostController@indexData')->name('admin.post.index.data');
            Route::get('unapproved', 'PostController@unapproved')->name('admin.post.unapproved');
            Route::get('unapprovedCount', 'PostController@unapprovedCount')->name('admin.post.unapprovedCount');
            Route::post('approve', 'PostController@approve')->name('admin.post.approve');
        });
        Route::resource('post', 'PostController');


        Route::group(['prefix' => 'comment'], function () {

        });
        Route::resource('comment', 'CommentController');


        Route::group(['prefix' => 'volunteer'], function () {
            Route::get('unanswered', 'VolunteerController@unanswered')->name('admin.volunteer.unanswered');
            Route::post('unanswered', 'VolunteerController@childUnanswered')->name('admin.volunteer.unanswered');
        });
//        Route::get('/request/{id}', 'VolunteerController@showRequest')->name('admin.request.show');

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
            });
            Route::get('cities', 'FacultyController@cities')->name('admin.faculty.cities');
        });
        Route::resource('faculty', 'FacultyController');


        Route::group(['prefix' => 'social'], function () {
            Route::get('unpublished', 'SocialController@unpublished')->name('admin.social.unpublished');
            Route::post('all', 'SocialController@index')->name('admin.social.published');
        });
        Route::resource('social', 'SocialController');



        Route::post('/process', 'ChildController@createProcess')->name('admin.process.store');


        Route::group(['prefix' => 'blood'], function () {
            Route::get('/data', 'BloodController@indexData')->name('admin.blood.index.data');
        });
        Route::resource('blood', 'BloodController');

        Route::group(['prefix' => 'new'], function () {
            Route::get('/channels', 'NewController@channelsData')->name('admin.new.channels.data');
        });

        Route::resource('blog', 'BlogController');
        Route::resource('new', 'NewController');


    });


    Route::get('/', 'FrontController@home')->name('front.home');
    Route::get('/basinda-biz.html', 'FrontController@news')->name('front.news');
    Route::get('/biz-kimiz.html', 'FrontController@us')->name('front.us');
    Route::get('/neler-soylediniz.html', 'FrontController@testimonials')->name('front.testimonials');
    Route::get('/basin-kiti.html', 'FrontController@newskit')->name('front.newskit');
    Route::get('/leyla-kimdir.html', 'FrontController@leyla')->name('front.leyla');
    Route::get('/sikca-sorulan-sorular.html', 'FrontController@sss')->name('front.sss');
    Route::get('/blog.html', 'FrontController@blogs')->name('front.blogs');
    Route::get('/blog/{name}.html', 'FrontController@blog')->name('front.blog');
    Route::get('/fakülteler.html', 'FrontController@faculties')->name('front.faculties');

    Route::get('/{facultyName}.html', 'FrontController@faculty')->name('front.faculty');
    Route::post('/{facultyName}/{childSlug}', 'FrontController@childMessage')->name('front.child.message');
    Route::get('/{facultyName}/{childSlug}.html', 'FrontController@child')->name('front.child');

});