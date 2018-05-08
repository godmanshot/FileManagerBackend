<?php

use App\Http\Requests\CreateDirectoryRequest;
use App\Http\Requests\DeleteDirectoryRequest;
use App\Http\Requests\GetDirectoryRequest;
use App\Http\Requests\PutFileRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/directory', function (GetDirectoryRequest $request) {

	$input = $request->validated();

	$list = Storage::disk('public')->directories($input['path']);
	$list  = array_map(function($value) {
		$name = $value;
		$value = [];
		$value['name'] = $name;
		return $value;
	}, $list);
	return $list;

});

Route::get('/directory/create', function (CreateDirectoryRequest $request) {

	$input = $request->validated();
	
	Storage::disk('public')->makeDirectory(trim($input['path'], ' ./').'/'.$input['name']);

});

Route::get('/directory/delete', function (DeleteDirectoryRequest $request) {

	$input = $request->validated();
	
	Storage::disk('public')->deleteDirectory($input['path']);

});

Route::post('/put', function (PutFileRequest $request) {

	$input = $request->validated();

	Storage::disk('public')->putFileAs(
	    $input['path'], $input['file'], $input['file']->getClientOriginalName()
	);

});
