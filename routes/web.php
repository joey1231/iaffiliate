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

 //AUTHENTICATION ROUTES
 Auth::routes();
Route::get('/', function () {
	//dd(\App\Libraries\Voluum::campaignReport('f139710e-d123-4fcb-9d56-ec74cdf4d190'));
    return redirect('login');
});
Route::get('/time',function(){
	return date('Y-m-d  H:i:s');
});
Route::group(['middleware' =>  'auth'],function(){
	Route::get('/logout', 'Auth\LoginController@logout');
 	Route::get('lander/datatable', 'LanderController@Datatable');
	Route::get('lander/datatable/{relation}/{id}', 'LanderController@DatatableDetails');
	Route::get('lander/list/bulk/{id}', 'LanderController@addBulk');
	Route::post('lander/list/add-bulk/{id}', 'LanderController@saveBulk');
	Route::post('lander/editor', 'LanderController@updateData');
	Route::resource('lander/list','LanderController');

	Route::get('lander-url/set-active/{id}', 'LanderUrlController@setActive');
	Route::post('lander-url/editor', 'LanderUrlController@updateData');
	Route::post('lander-url/store/{lander_id}','LanderUrlController@store');
	Route::delete('lander-url/{id}','LanderUrlController@destroy');

	Route::get('report/log/datatable/{type}', 'ReportController@DatatableLog');
	Route::get('report/datatable', 'ReportController@Datatable');
	Route::get('report/run-algo', 'ReportController@report');
	Route::post('report/pause/{id}','ReportController@manualPause');
	Route::post('report/resume/{id}','ReportController@manualResume');
	Route::get('report/log/{name}/{type}', 'ReportController@log');
	Route::resource('report','ReportController');

	Route::get('campaign/report/datatable/{id}', 'CampaignController@reportDatatable');
	Route::get('campaign/{id}/report', 'CampaignController@report');
	Route::post('campaign/toggle/{id}', 'CampaignController@toggleStart');
	Route::get('campaign/datatable', 'CampaignController@Datatable');
	Route::resource('campaign','CampaignController');

	Route::get('user/{id}/report', 'UserController@report');
	Route::post('user/toggle/{id}', 'UserController@toggleStart');
	Route::get('user/datatable', 'UserController@Datatable');
	Route::resource('user','UserController');

});
