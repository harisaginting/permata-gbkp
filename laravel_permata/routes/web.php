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
    return view('landing');
});
// Auth::routes();


Route::post('auth/check_email_avaliable', 'AuthController@checkEmailAvaliable');

Route::post('json/select2-anggota', 'JsonController@select2Anggota');
 

/**
 * ===================== FRONTEND ======================
 */
Route::group(['as' => 'frontend.'], function () {
    Route::get('/', 'LandingController@index')->name('home');
    Route::get('/home', function () {return redirect()->route('frontend.home');});

    Route::get('/login', 'LandingController@login')->name('login');
    Route::get('/edit-profile', 'MemberController@editProfile')->name('edit-profile');
    Route::post('/edit-profile-progress', 'MemberController@editProfileProgress')->name('edit-profile');
    Route::post('/upload-photo-profile', 'MemberController@uploadPhotoProgress')->name('upload-photo-profile');
    Route::get('/logout', 'MemberController@logout')->name('logout');
    Route::get('/register', 'LandingController@register')->name('register');
    Route::post('/register-process', 'MemberController@registerProcess');

    Route::get('/info', 	'LandingController@information')->name('info');
    Route::get('/artikel', 	'LandingController@artikel')->name('artikel');

    // EVENT
    Route::get('/covid19', 'EventController@covid19')->name('covid-19');
    Route::get('/khotbah', function () {return redirect("https://www.youtube.com/watch?v=3Dr55xXF_Uk");});
    
    Route::get('/yt/berkat-kemuliaanmu', function () {return redirect("https://www.youtube.com/watch?v=0U03DMJtkKI");});
    Route::get('/yt/berkat-kemurahanmu', function () {return redirect("https://www.youtube.com/watch?v=0U03DMJtkKI");});

    Route::group(['prefix' => '/member'], function () {
	    Route::get('/activation/{code_activation}', 'MemberController@activation');
	    Route::get('/forgot-password/', 'LandingController@forgotPassword');
	    Route::post('/forgot-password/', 'MemberController@forgotPasswordProcess');
	    
	    Route::get('/reset-password/{code}', 'MemberController@resetPassword');
        Route::post('/reset-password-proccess/', 'MemberController@resetPasswordProcess');
	
        Route::get('/', 'MemberController@profile');
        Route::get('/profile/', 'MemberController@profile');
        Route::post('/login-process/', 'MemberController@login');
    });
});


// ================== 	BACKEND  ==============================

Route::namespace('Backend')->prefix('application')->group(function(){
	Route::get('/register', 'AuthController@register')->name('register');
	Route::get('/login', 'AuthController@login')->name('login');
	Route::get('/logout', 'AuthController@logout')->name('logout');
	Route::post('/login_process', 'AuthController@loginProcess')->name('login_process');
	Route::post('/register_process', 'AuthController@registerProcess')->name('register_process');

	// Email
	Route::get('/email/test', 'EmailController@sendEmailTest');
	Route::get('/email/send-minggu', 'EmailController@sendEmailMinggu');
	Route::get('/email/send-birthday', 'EmailController@sendEmailBirthday');

	// Util
	Route::get('/refresh-data', 'UtilityController@refreshUserData');

	Route::group(['middleware' => 'login'], function(){
		// Dashboard
		Route::get('/', 'DashboardController@index')->name('application');
		// Route::get('/rakor3export', 'EventController@rakor3export');
		
		// Anggota
		Route::get('/anggota', 'AnggotaController@index');
		Route::get('/anggota/profile/{id}', 'AnggotaController@profile');
		Route::get('/anggota/edit/{id}', 'AnggotaController@edit');
		Route::get('/anggota/delete/{id}', 'AnggotaController@delete');
		Route::get('/anggota/upload', 'AnggotaController@upload_anggota');
		Route::post('/anggota/upload_data_anggota', 'AnggotaController@upload_anggota_process')->name('upload_data_anggota');

		Route::post('/anggota/update-process', 'AnggotaController@updateProcess');

		// acara
		Route::get('/acara', 'AcaraController@index');

		// artikel
		Route::get('/artikel', 'ArtikelController@index');

		// pa
		Route::get('/pa', 'AcaraController@pa');
		Route::post('/update_pa', 'AcaraController@update_pa');
		Route::post('/get_pa', 'AcaraController@get_pa');
		Route::post('/get_pa-view', 'AcaraController@getPaView');
		Route::post('/get-peserta-pa', 'AcaraController@getPesertaPa');
		Route::post('/update-peserta-pa', 'AcaraController@updatePesertaPa');

		// Keuangan
		Route::get('/keuangan/pemasukan', 'KeuanganController@pemasukan');
		Route::get('/keuangan/pengeluaran', 'KeuanganController@pengeluaran');
		Route::post('/keuangan/update-pengeluaran', 'KeuanganController@updatePengeluaran');
		Route::get('/keuangan/upload-kas', 'KeuanganController@upload_kas');
		Route::post('/keuangan/upload_data_kas', 'KeuanganController@upload_kas_process')->name('upload_data_kas');
		Route::post('/keuangan/add_iuran_kas', 'KeuanganController@add_iuran_kas');
		Route::post('/keuangan/delete_iuran_kas', 'KeuanganController@delete_iuran_kas');
		Route::post('/keuangan/delete-pengeluaran', 'KeuanganController@deletePengeluaran');
		Route::post('/keuangan/add_pemasukan_kantin', 'KeuanganController@addPemasukanKantin');
		Route::post('/keuangan/update_pemasukan_kantin', 'KeuanganController@updatePemasukanKantin');
		Route::post('/keuangan/get-pemasukan-kantin', 'KeuanganController@getPemasukanKantin');

		//Datatable 
		Route::post('/datatable_anggota', 'AnggotaController@datatable_anggota');
		Route::post('/datatable_iuran_kas', 'KeuanganController@datatable_iuran_kas');
		Route::post('/datatable_pa', 'AcaraController@datatable_pa');
		Route::post('/datatable_persembahan_pa', 'KeuanganController@datatable_persembahan_pa');
		Route::post('/datatable_pemasukan_kantin', 'KeuanganController@datatablePemasukanKantin');
		Route::post('/datatable-pengeluaran-kas', 'KeuanganController@datatablePengaluaranKas');

		// Json
		Route::post('/json/anggota', 'JsonController@list_anggota');
		Route::post('/json/data-agenda', 'AgendaController@list_agenda');

		// Agenda
		Route::get('/agenda', 'AgendaController@index');
		Route::post('/agenda/list_agenda', 'AgendaController@list_agenda');
		Route::post('/agenda/update_agenda', 'AgendaController@update_agenda');
		Route::post('/agenda/update_jam_agenda', 'AgendaController@update_jam_agenda');
		Route::post('/agenda/delete_agenda', 'AgendaController@delete_agenda');

		// Agenda
		Route::get('/email', 'EmailController@index');
		Route::post('/email/send-broadcast', 'EmailController@sendEmailBroadcast');
	});
});

Route::group(['prefix' => '/application'], function () {
	


	
});

// ================== 	CUSTOM  ==============================
Route::group(['middleware' => 'login'], function(){
		Route::get('/rakor3export', 'EventController@rakor3export');
});
Route::group(['prefix' => '/event'], function () {
	Route::get('/', 'EventController@index');
	Route::get('/rakor3', 'EventController@rakor3');
	Route::get('/rakor3/set-attendance/{phone?}/{present?}', 'EventController@rakor3setattendance');
	Route::get('/rakor3/scanner/', 'EventController@rakor3scanner');
	Route::get('/rakor3/{phone}', 'EventController@rakor3attendance');
});