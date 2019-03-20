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
        'middleware' => ['guest:admin', 'guest:web'],
        'uses' => 'UserController@index',
        'as' => 'home'
    ]);

    Route::group(['middleware' => 'beranda'], function () {

        Route::put('profile/update', [
            'uses' => 'UserController@updateProfile',
            'as' => 'update.profile'
        ]);

        Route::put('account/update', [
            'uses' => 'UserController@updateAccount',
            'as' => 'update.account'
        ]);

        Route::get('profil/{role}/{id}', [
            'uses' => 'UserController@showProfile',
            'as' => 'show.profile'
        ]);

        Route::get('staff', [
            'uses' => 'UserController@showStaff',
            'as' => 'show.staff'
        ]);

        Route::get('beranda', [
            'uses' => 'UserController@beranda',
            'as' => 'beranda'
        ]);

    });

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
            'middleware' => 'surat.masuk',
            'uses' => 'SuratMasukController@showSuratMasuk',
            'as' => 'show.surat-masuk'
        ]);

        Route::group(['middleware' => 'pengolah'], function () {

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

        });

        Route::group(['middleware' => 'kadin'], function () {

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

        Route::group(['prefix' => 'agenda', 'middleware' => 'TU'], function () {

            Route::get('/', [
                'uses' => 'AgendaSuratMasukController@showAgenda',
                'as' => 'show.agenda-masuk'
            ]);

            Route::post('create', [
                'uses' => 'AgendaSuratMasukController@createAgenda',
                'as' => 'create.agenda-masuk'
            ]);

            Route::get('edit/{id}', [
                'uses' => 'AgendaSuratMasukController@editAgenda',
                'as' => 'edit.agenda-masuk'
            ]);

            Route::put('update/{id}', [
                'uses' => 'AgendaSuratMasukController@updateAgenda',
                'as' => 'update.agenda-masuk'
            ]);

            Route::get('update/{id}', [
                'uses' => 'AgendaSuratMasukController@deleteAgenda',
                'as' => 'delete.agenda-masuk'
            ]);

        });

    });

    Route::group(['prefix' => 'surat_keluar'], function () {

        Route::get('/', [
            'middleware' => 'surat.keluar',
            'uses' => 'SuratKeluarController@showSuratKeluar',
            'as' => 'show.surat-keluar'
        ]);

        Route::get('{id}/pdf', [
            'uses' => 'SuratKeluarController@pdfSuratKeluar',
            'as' => 'pdf.surat-keluar'
        ]);

        Route::post('create', [
            'middleware' => 'pegawai',
            'uses' => 'SuratKeluarController@createSuratKeluar',
            'as' => 'create.surat-keluar'
        ]);

        Route::get('edit/{id}', [
            'middleware' => 'surat.keluar',
            'uses' => 'SuratKeluarController@editSuratKeluar',
            'as' => 'edit.surat-keluar'
        ]);

        Route::put('update/{id}', [
            'middleware' => 'surat.keluar',
            'uses' => 'SuratKeluarController@updateSuratKeluar',
            'as' => 'update.surat-keluar'
        ]);

        Route::get('delete/{id}', [
            'middleware' => 'pegawai',
            'uses' => 'SuratKeluarController@deleteSuratKeluar',
            'as' => 'delete.surat-keluar'
        ]);

        Route::get('konfirmasi/{id}', [
            'middleware' => 'pegawai',
            'uses' => 'SuratKeluarController@konfirmasiSuratKeluar',
            'as' => 'confirm.surat-keluar'
        ]);

        Route::group(['prefix' => 'agenda', 'middleware' => 'TU'], function () {

            Route::get('/', [
                'uses' => 'AgendaSuratKeluarController@showAgenda',
                'as' => 'show.agenda-keluar'
            ]);

            Route::post('create', [
                'uses' => 'AgendaSuratKeluarController@createAgenda',
                'as' => 'create.agenda-keluar'
            ]);

            Route::get('edit/{id}', [
                'uses' => 'AgendaSuratKeluarController@editAgenda',
                'as' => 'edit.agenda-keluar'
            ]);

            Route::put('update/{id}', [
                'uses' => 'AgendaSuratKeluarController@updateAgenda',
                'as' => 'update.agenda-keluar'
            ]);

            Route::get('update/{id}', [
                'uses' => 'AgendaSuratKeluarController@deleteAgenda',
                'as' => 'delete.agenda-keluar'
            ]);

            Route::get('massDelete/{id}', [
                'uses' => 'AgendaSuratKeluarController@massDeleteFileSuratKeluar',
                'as' => 'massDelete.surat-keluar'
            ]);

        });

    });

});

Route::group(['namespace' => 'Admins', 'prefix' => 'admin', 'middleware' => 'root'], function () {

    Route::group(['prefix' => 'tables'], function () {

        Route::group(['namespace' => 'DataMaster'], function () {

            Route::group(['prefix' => 'accounts'], function () {

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

                    Route::post('create', [
                        'uses' => 'AccountsController@createUsers',
                        'as' => 'create.users'
                    ]);

                    Route::put('{id}/update/profile', [
                        'uses' => 'AccountsController@updateProfileUsers',
                        'as' => 'update.profile.users'
                    ]);

                    Route::put('{id}/update/account', [
                        'uses' => 'AccountsController@updateAccountUsers',
                        'as' => 'update.account.users'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteUsers',
                        'as' => 'delete.users'
                    ]);

                });

            });

            Route::group(['prefix' => 'web_contents'], function () {

                Route::group(['prefix' => 'carousels'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showCarouselsTable',
                        'as' => 'table.carousels'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createCarousels',
                        'as' => 'create.carousels'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateCarousels',
                        'as' => 'update.carousels'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteCarousels',
                        'as' => 'delete.carousels'
                    ]);

                });

                Route::group(['prefix' => 'jenis_surat'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showJenisSuratTable',
                        'as' => 'table.jenis-surat'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createJenisSurat',
                        'as' => 'create.jenis-surat'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateJenisSurat',
                        'as' => 'update.jenis-surat'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteJenisSurat',
                        'as' => 'delete.jenis-surat'
                    ]);

                });

                Route::group(['prefix' => 'perihal_surat'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPerihalSuratTable',
                        'as' => 'table.perihal-surat'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPerihalSurat',
                        'as' => 'create.perihal-surat'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePerihalSurat',
                        'as' => 'update.perihal-surat'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePerihalSurat',
                        'as' => 'delete.perihal-surat'
                    ]);

                });

            });

        });

        Route::group(['namespace' => 'DataTransaction'], function () {

            Route::group(['prefix' => 'surat'], function () {

                Route::group(['prefix' => 'masuk'], function () {

                    Route::get('/', [
                        'uses' => 'SuratController@showSuratMasuk',
                        'as' => 'table.surat-masuk'
                    ]);

                    Route::get('pdf/{ids}', [
                        'uses' => 'SuratController@massPdfSuratMasuk',
                        'as' => 'massPDF.surat-masuk'
                    ]);

                    Route::post('delete', [
                        'uses' => 'SuratController@massDeleteSuratMasuk',
                        'as' => 'massDelete.surat-masuk'
                    ]);

                });

                Route::group(['prefix' => 'disposisi'], function () {

                    Route::get('/', [
                        'uses' => 'SuratController@showSuratDisposisi',
                        'as' => 'table.surat-disposisi'
                    ]);

                    Route::get('pdf/{ids}', [
                        'uses' => 'SuratController@massPdfSuratDisposisi',
                        'as' => 'massPDF.surat-disposisi'
                    ]);

                    Route::post('delete', [
                        'uses' => 'SuratController@massDeleteSuratDisposisi',
                        'as' => 'massDelete.surat-disposisi'
                    ]);

                });

                Route::group(['prefix' => 'keluar'], function () {

                    Route::get('/', [
                        'uses' => 'SuratController@showSuratKeluar',
                        'as' => 'table.surat-keluar'
                    ]);

                    Route::get('pdf/{ids}', [
                        'uses' => 'SuratController@massPdfSuratKeluar',
                        'as' => 'massPDF.surat-keluar'
                    ]);

                    Route::post('delete', [
                        'uses' => 'SuratController@massDeleteSuratKeluar',
                        'as' => 'massDelete.surat-keluar'
                    ]);

                });

            });

            Route::group(['prefix' => 'agenda_surat'], function () {

                Route::group(['prefix' => 'masuk'], function () {

                    Route::get('/', [
                        'uses' => 'AgendaController@showAgendaMasuk',
                        'as' => 'table.agenda-masuk'
                    ]);

                    Route::get('pdf/{ids}', [
                        'uses' => 'AgendaController@massPdfAgendaMasuk',
                        'as' => 'massPDF.agenda-masuk'
                    ]);

                    Route::post('delete', [
                        'uses' => 'AgendaController@massDeleteAgendaMasuk',
                        'as' => 'massDelete.agenda-masuk'
                    ]);

                });

                Route::group(['prefix' => 'keluar'], function () {

                    Route::get('/', [
                        'uses' => 'AgendaController@showAgendaKeluar',
                        'as' => 'table.agenda-keluar'
                    ]);

                    Route::get('pdf/{ids}', [
                        'uses' => 'AgendaController@massPdfAgendaKeluar',
                        'as' => 'massPDF.agenda-keluar'
                    ]);

                    Route::post('delete', [
                        'uses' => 'AgendaController@massDeleteAgendaKeluar',
                        'as' => 'massDelete.agenda-keluar'
                    ]);

                });

            });

        });

    });

});
