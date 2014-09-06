<?php

use App\Recommendation\Recommender;

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

Route::get('recommend.json', function(Request $request) {
	$repository = new \App\Champion\Repository;
	$store = new \App\Champion\Store($repository);

	$recommender = new Recommender($repository, $store);

	$recommender->addCritic(new \App\Recommendation\Critics\BasicEnemyCritic($repository, $store));
	$recommender->addCritic(new \App\Recommendation\Critics\BasicAllyCritic($repository, $store));
	$recommender->addCritic(new \App\Recommendation\Critics\CounterCritic($repository, $store));
	
	$role = Request::query('role', 'mid');
	$allies = explode(',', Request::query('allies'));
	$enemies = explode(',', Request::query('enemies'));

	$recommendations = $recommender->recommend($allies, $enemies, $role);
	
	return $recommendations;
});
