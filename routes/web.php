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


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


    Route::group(['middleware' => 'admin','prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::put('/update/profile/{id}', 'AdminController@update')->name('admin_profile');
        Route::get('/crud', 'AdminController@getcrud')->name('showcrud');
        Route::get('/showllogaritpagen', 'AdminController@getviewLlogaritPagen')->name('showllogaritpagen');
        Route::post('/llogaritpagen', 'AdminController@returnCalculatedSalary')->name('llogaritpagenBruto');

        Route::get('/showviewraportiishitjes/{id}', 'HistoricalSalesReport@getviewsalesreport')->name('showviewraportiishitjes');
        Route::get('/showviewraport', 'HistoricalSalesReport@getreport')->name('showviewraport');
        Route::post('/shfaqraportiishitjes/{id}', 'HistoricalSalesReport@openReport')->name('shfaqraportiishitjes');
        
        Route::post('/show/user', 'AdminController@getUsers')->name('showusers');
        Route::get('/delete/user/{id}', 'AdminController@delete')->name('deleteuser');
        Route::get('/showform', 'AdminController@create');
        Route::post('/save/user', 'AdminController@store')->name('add_newuser');
        Route::get('/showeditform/{id}', 'AdminController@edit');
        Route::post('/update/users/profile/{user_id}', 'AdminController@updateUser')->name('edit_user_profile');


        Route::get('/jquery-tree-view',array('as'=>'jquery.treeview','uses'=>'DepartmentsController@index'));
        Route::post('/new/dep', 'DepartmentsController@store')->name('add_newdepartament');
        Route::get('/dep/crud/{id}', 'DepartmentsController@getdepcrud')->name('showdepcrud');
        Route::post('/show/user/of/dep/', 'DepartmentsController@getUsersofDep')->name('showdepusers');
        Route::get('/delete/departament/{id}', 'DepartmentsController@deteledep_withid')->name('delete_dep_id');
        Route::get('/edit_dep_form/{id}', 'DepartmentsController@edit');
        Route::put('/update/dep/info/{depart_id}', 'DepartmentsController@editDepartament')->name('update_departament_info');

        Route::get('/chat/page', 'ChatController@index')->name('chatpage');
        Route::post('/chat/messages', 'ChatController@retrieveChatMessages')->name('chatmessages');
        Route::post('/sent/chat/messages', 'ChatController@sendMessage')->name('send_chatmessages');
    });
Route::resource('profile', 'ProfileController');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/user', 'UserController');

Route::get('/chat/page', 'ChatController@index')->name('chatpage');
Route::post('/chat/messages', 'ChatController@retrieveChatMessages')->name('chatmessages');
Route::post('/sent/chat/messages', 'ChatController@sendMessage')->name('send_chatmessages');
