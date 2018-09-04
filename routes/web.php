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
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('index');

//test routes
Route::prefix('test')->group(function () {

	Route::get('/value', 'HomeController@testValue')->name('test_value');
	Route::get('/dhis', 'HomeController@testDhis')->name('test_dhis');

});

// login routes
Route::prefix('login')->namespace('Auth')->group(function () {

	Route::get('/', 'LoginController@showLoginMemberForm')->middleware('member_guest')->name('login');

	Route::get('/admin', 'LoginController@showLoginAdminForm')->middleware('admin_guest');
	Route::post('/admin', 'LoginController@loginAdmin')->name('login_admin')->middleware('admin_guest');

	Route::get('/member', 'LoginController@showLoginMemberForm')->middleware('member_guest');
	Route::post('/member', 'LoginController@loginMember')->name('login_member')->middleware('member_guest');

});

//logout routes
Route::prefix('logout')->namespace('Auth')->group(function () {

	Route::get('/admin', 'LoginController@logoutAdmin')->name('logout_admin');
	Route::get('/member', 'LoginController@logoutMember')->name('logout_member');

});

//Auth::routes();

Route::prefix('member')->middleware('auth:member')->group(function () {

	Route::get('/', 'MemberController@index')->name('index_member');
	Route::get('/dashboard', 'MemberController@index')->name('dashboard_member');
	Route::get('/activity', 'MemberController@index_activity')->name('activity_member');

	Route::prefix('profile')->group(function () {
		
		Route::get('/', 'MemberController@view_profile')->name('profile_member');
		Route::post('/update/{id}/detail', 'UserController@update_member_user_proses')->name('update_profile_member');
		Route::post('/update/{id}/email', 'UserController@update_member_email_proses')->name('update_email_member');
		Route::post('/update/{id}/password', 'UserController@update_member_password_proses')->name('update_password_member');
		Route::post('/update/{id}/setting', 'UserController@update_member_setting_proses')->name('update_setting_member');

	});

	Route::prefix('pelaporan')->group(function () {
		
		Route::get('/', 'MemberController@index_pelaporan')->name('list_pelaporan_member');
		Route::get('/{id}', 'FormController@view_form_value_member')->name('view_pelaporan_member');
		Route::get('/{id}/create', 'FormController@create_form_member')->name('create_pelaporan_member');
		Route::get('/{id}/view/{sub}', 'FormController@view_submisi_member')->name('view_submisi_member');

	});

	Route::prefix('report')->group(function () {
		
		Route::get('/{id}', 'MemberController@index_activity_member')->name('list_activity_member');

		Route::prefix('generate')->group(function () {
			
			Route::get('/activity', 'MemberController@index_generate_activity_member')->name('generate_activity_member');
			Route::get('/send', 'MemberController@index_activity_member')->name('generate_send_member');

		});

		Route::prefix('download')->group(function () {
			
			Route::get('/excel/{id}', 'FormController@generate_pelaporan_excel_proses')->name('download_excel_activity_member');
			Route::get('/json', 'FormController@generate_pelaporan_json_proses')->name('download_json_activity_member');

		});
	});

});

Route::prefix('admin')->middleware('auth:admin')->group(function () {

	Route::get('/', 'AdminController@index');
	Route::get('/dashboard', 'AdminController@index')->name('dashboard_admin');
	Route::get('/profile', 'AdminController@view_profile')->name('profile_admin');
	
	Route::prefix('config')->group(function () {
		
		Route::get('/', 'AdminController@index_config')->name('index_config_admin');
		Route::post('/', 'AdminController@update_config_proses')->name('update_config_admin');
		Route::get('/puskesmas', 'AdminController@index_puskesmas')->name('index_puskesmas_admin');
		Route::post('/puskesmas', 'AdminController@update_puskesmas_proses')->name('update_puskesmas_admin');

	});

	Route::prefix('member')->group(function () {

		Route::get('/', 'AdminController@index_user')->name('list_member_admin');
		Route::post('/', 'UserController@add_admin_user_proses')->name('add_member_admin');
		Route::get('/delete/{id}', 'UserController@delete_admin_user_proses')->name('delete_member_admin');
		Route::post('/update/{id}', 'UserController@update_admin_user_proses')->name('update_member_admin');
		Route::post('/update/{id}/password', 'UserController@update_admin_password_proses')->name('update_password_member_admin');
		Route::post('/update/{id}/email', 'UserController@update_admin_email_proses')->name('update_email_member_admin');
		Route::post('/permission/{id}/add', 'UserController@add_admin_permission_proses')->name('add_permission_member_admin');
		Route::get('/permission/{id}/remove/{permission}', 'UserController@delete_admin_permission_proses')->name('delete_permission_member_admin');

	});
	
	Route::prefix('permission')->group(function () {
		
		Route::get('/', 'AdminController@index_permission')->name('list_permission_admin');
		Route::post('/', 'PermissionController@add_admin_permission_proses')->name('add_permission_admin');
		Route::get('/delete/{id}', 'PermissioController@delete_admin_permission_proses')->name('delete_permission_admin');
		Route::get('/update/{id}', 'PermissioController@update_admin_permission_proses')->name('update_permission_admin');

	});

	Route::prefix('sip')->group(function () {

		Route::prefix('activity')->group(function () {
			
			Route::get('/', 'FormController@index_activity')->name('list_activity_admin');
			Route::post('/', 'FormController@add_admin_activity_proses')->name('add_activity_admin');
			Route::get('/delete/{id}', 'FormController@delete_admin_activity_proses')->name('delete_activity_admin');
			Route::get('/update/{id}', 'FormController@update_admin_activity_proses')->name('update_activity_admin');

		});

		Route::prefix('value')->group(function () {
			
			Route::get('/{id}', 'FormController@view_form_value')->name('view_form_admin');

		});

		Route::prefix('form')->group(function () {
			
			Route::get('/', 'FormController@index_form')->name('list_form_admin');
			Route::post('/', 'FormController@add_admin_form_proses')->name('add_form_admin');
			Route::post('/{id}/update', 'FormController@update_admin_form_proses')->name('update_form_admin');
			Route::get('/{id}/delete', 'FormController@delete_admin_form_proses')->name('delete_form_admin');

			Route::get('/{id}', 'FormController@index_subform')->name('detail_form_admin');
			Route::post('/{id}/sub', 'FormController@add_subform_proses')->name('add_subform_admin');
			Route::post('/{id}/sub/update', 'FormController@update_subform_proses')->name('update_subform_admin');
			Route::get('/{id}/sub/delete', 'FormController@delete_subform_proses')->name('delete_subform_admin');

			Route::get('/{id}/sub/{sub}', 'FormController@detail_admin_subform')->name('list_subform_admin');
			Route::post('/{id}/sub/{sub}/col', 'FormController@add_column_proses')->name('add_column_admin');
			Route::post('/{id}/sub/{sub}/row', 'FormController@add_row_proses')->name('add_row_admin');
			Route::post('/{id}/sub/{sub}/group', 'FormController@add_admin_group_proses')->name('add_group_admin');

		});

	});

});