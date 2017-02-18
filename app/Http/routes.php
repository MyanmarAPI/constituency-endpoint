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

$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->group([
    'prefix'    => '/health-check',
], function () use ($app)
{
    $app->get('/', function() {
        return response_ok(['message' => 'Ok.']);
    });
});

$app->group([
	'middleware' 	=> 'auth',
	'prefix' 		=> 'constituency/v1',
	'namespace' 	=> 'App\Http\Controllers' 
	], function () use ($app)
	{
	    $app->get('state_region', 'RegionController@getList');

	    $app->get('state_region/{pcode}', 'RegionController@getByPcode');

	    $app->get('township', 'TownshipController@getList');

		$app->get('township/{pcode}', 'TownshipController@getByPcode');	    

	    $app->get('ward_village', 'WardVillageController@getList');

	    //$app->get('ward_village/{id}', 'WardVillageController@getByID');
	}
);
