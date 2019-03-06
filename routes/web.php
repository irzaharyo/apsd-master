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

    Route::get('surat-{surat}/{id}/files', [
        'uses' => 'UserController@showFileSurat',
        'as' => 'show.fileSurat'
    ]);

    Route::get('{kode}/perihal', [
        'uses' => 'UserController@getPerihalSurat',
        'as' => 'get.perihalSurat'
    ]);

    Route::group(['prefix' => 'surat_masuk'], function () {

        Route::get('/', [
            'uses' => 'SuratMasukController@showSuratMasuk',
            'as' => 'show.surat-masuk'
        ]);

        Route::post('create', [
            'uses' => 'SuratMasukController@createSuratMasuk',
            'as' => 'create.surat-masuk'
        ]);

        Route::get('edit/{id}', [
            'uses' => 'SuratMasukController@editSuratMasuk',
            'as' => 'edit.surat-masuk'
        ]);

        Route::put('update/{id}', [
            'uses' => 'SuratMasukController@updateSuratMasuk',
            'as' => 'update.surat-masuk'
        ]);

        Route::get('delete/{id}', [
            'uses' => 'SuratMasukController@deleteSuratMasuk',
            'as' => 'delete.surat-masuk'
        ]);

        Route::get('massDelete/{id}', [
            'uses' => 'SuratMasukController@massDeleteFileSuratMasuk',
            'as' => 'massDelete.surat-masuk'
        ]);

        Route::post('disposisi/create', [
            'uses' => 'SuratMasukController@createSuratDisposisi',
            'as' => 'create.surat-disposisi'
        ]);

        Route::get('disposisi/edit/{id}', [
            'uses' => 'SuratMasukController@editSuratDisposisi',
            'as' => 'edit.surat-disposisi'
        ]);

        Route::put('disposisi/update/{id}', [
            'uses' => 'SuratMasukController@updateSuratDisposisi',
            'as' => 'update.surat-disposisi'
        ]);

        Route::get('disposisi/delete/{id}', [
            'uses' => 'SuratMasukController@deleteSuratDisposisi',
            'as' => 'delete.surat-disposisi'
        ]);

    });

    Route::group(['prefix' => 'surat_keluar'], function () {

        Route::get('/', [
            'uses' => 'SuratKeluarController@showSuratKeluar',
            'as' => 'show.surat-keluar'
        ]);

    });

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
