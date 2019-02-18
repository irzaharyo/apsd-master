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

Route::post('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Auth::routes();

Route::group(['namespace' => 'Auth', 'prefix' => 'account'], function () {

    Route::get('/', [
        'uses' => 'LoginController@showLoginForm',
        'as' => 'show.login.form'
    ]);

    Route::post('login', [
        'uses' => 'LoginController@login',
        'as' => 'login'
    ]);

    Route::post('logout', [
        'uses' => 'LoginController@logout',
        'as' => 'logout'
    ]);

});

Route::group(['prefix' => '/'], function () {

    Route::get('/', [
        'uses' => 'UserController@index',
        'as' => 'home'
    ]);

    Route::get('beranda', [
        'uses' => 'UserController@beranda',
        'as' => 'beranda'
    ]);

    Route::get('surat_keluar', [
        'uses' => 'UserController@showSuratKeluar',
        'as' => 'show.suratKeluar'
    ]);

    Route::get('surat_masuk', [
        'uses' => 'UserController@showSuratMasuk',
        'as' => 'show.suratMasuk'
    ]);

    Route::get('surat_disposisi', [
        'uses' => 'UserController@showSuratDisposisi',
        'as' => 'show.suratDisposisi'
    ]);

});


Route::group(['namespace' => 'Admins', 'prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'AdminController@index',
        'as' => 'home-admin'
    ]);

    Route::put('profile/update', [
        'uses' => 'AdminController@updateProfile',
        'as' => 'admin.update.profile'
    ]);

    Route::put('account/update', [
        'uses' => 'AdminController@updateAccount',
        'as' => 'admin.update.account'
    ]);

    Route::group(['prefix' => 'tables'], function () {

        Route::group(['prefix' => 'accounts', 'middleware' => 'root'], function () {

            Route::group(['prefix' => 'admins'], function () {

                Route::get('/', [
                    'uses' => 'AccountsController@showAdminsTable',
                    'as' => 'table.admins'
                ]);

                Route::post('create', [
                    'uses' => 'AccountsController@createAdmins',
                    'as' => 'create.admins'
                ]);

                Route::put('{id}/update/profile', [
                    'uses' => 'AccountsController@updateProfileAdmins',
                    'as' => 'update.profile.admins'
                ]);

                Route::put('{id}/update/account', [
                    'uses' => 'AccountsController@updateAccountAdmins',
                    'as' => 'update.account.admins'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'AccountsController@deleteAdmins',
                    'as' => 'delete.admins'
                ]);

            });

            Route::group(['prefix' => 'users'], function () {

                Route::get('/', [
                    'uses' => 'AccountsController@showUsersTable',
                    'as' => 'table.users'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'AccountsController@deleteUsers',
                    'as' => 'delete.users'
                ]);

            });

        });

    });

});