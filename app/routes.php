<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//este es oara el evento GET de la pagina inicial
Route::get('/',array('as'=>'index_page','uses'=>'ImageController@getIndex'));

//este es para el evento POST de la pagina inicial
Route::post('/',array('as'=>'index_page_post','before'=>'csrf','uses'=>'ImageController@postIndex'));

Route::get('snatch/{id}',
	array('as'=>'get_image_information','uses'=>'ImageController@getSnatch'))
	->where('id','[0-9]+');

Route::get('all',
	array('as'=>'all_images','uses'=>'ImageController@getAll'));

Route::get('delete/{id}',
	array('as'=>'delete_image','uses'=>'ImageController@getDelete'))
	->where('id','[0-9]+');
