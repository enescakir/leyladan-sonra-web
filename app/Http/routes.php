<?php
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

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/deneme', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::auth();
        Route::get('/', function () { return redirect('/admin/login'); })->name('admin.login');
        Route::get('/blank', 'DashboardController@blank')->name('admin.blank');

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard');
            Route::get('birthdays','DashboardController@birthdays')->name('admin.dashboard.birthdays');
            Route::get('childrenCountbyGeneral', 'DashboardController@children_by_general')->name('admin.dashboard.childrenCountbyGeneral');
            Route::get('childrenCountbyFaculty', 'DashboardController@children_by_faculty')->name('admin.dashboard.childrenCountbyFaculty');
        });

        Route::group(['prefix' => 'statics'], function () {
            Route::get('user', 'StaticController@user')->name('admin.statics.user');
            Route::get('horoscope', 'StaticController@horoscope' )->name('admin.statics.horoscope');
        });

        Route::group(['prefix' => 'post'], function () {
            Route::get('all', 'PostController@all')->name('admin.post.all');
            Route::get('all/data', 'PostController@allData')->name('admin.post.all.data');
            Route::get('faculty', 'PostController@faculty')->name('admin.post.faculty');
            Route::get('faculty/data', 'PostController@facultyData')->name('admin.post.faculty.data');
            Route::get('unapproved', 'PostController@unapproved')->name('admin.post.unapproved');
            Route::get('unapprovedCount', 'PostController@unapprovedCount')->name('admin.post.unapprovedCount');
            Route::post('{id}/approve', 'PostController@approve')->name('admin.post.approve');
            Route::post('{id}/unapprove', 'PostController@unapprove')->name('admin.post.unapprove');
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
                Route::post('approve', 'UserController@approve')->name('admin.user.approve');
                Route::post('unapprove', 'UserController@unapprove')->name('admin.user.unapprove');
            });
        });
        Route::resource('user', 'UserController');


        Route::group(['prefix' => 'child'], function () {
        });
        Route::resource('child', 'ChildController');

        Route::group(['prefix' => 'faculty'], function () {
            Route::group(['prefix' => '{id}'], function () {
                Route::get('children', 'FacultyController@children')->name('admin.faculty.children');
                Route::get('children/data', 'FacultyController@childrenData')->name('admin.faculty.children.data');
                Route::get('users', 'FacultyController@users')->name('admin.faculty.users');
                Route::get('users/unapproved', 'FacultyController@unapprovedUsers')->name('admin.faculty.users.unapproved');
                Route::get('users/unapprovedCount', 'FacultyController@unapprovedUsersCount')->name('admin.faculty.users.unapprovedCount');
            });
            Route::get('cities', 'FacultyController@cities')->name('admin.faculty.cities');
        });
        Route::resource('faculty', 'FacultyController');


        Route::group(['prefix' => 'social'], function () {
            Route::get('unpublished', 'SocialController@unpublished')->name('admin.social.unpublished');
            Route::post('all', 'SocialController@index')->name('admin.social.published');
        });
        Route::resource('social', 'SocialController');



        Route::post('/process/{id}', 'ChildController@createProcess')->name('admin.process.store');


        Route::resource('blood', 'BloodController');

    });


});