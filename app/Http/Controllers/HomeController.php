<?php namespace App\Http\Controllers;

use App\Recommendation\Recommender;
use Illuminate\Routing\Controller;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@index');
	|
	*/

	public function index()
	{

		$repository = new \App\Champion\Repository;
		$store = new \App\Champion\Store($repository);

		$recommender = new Recommender($repository, $store);

		$recommender->addCritic(new \App\Recommendation\Critics\BasicEnemyCritic($repository, $store));
		$recommender->addCritic(new \App\Recommendation\Critics\BasicAllyCritic($repository, $store));
		$recommender->addCritic(new \App\Recommendation\Critics\CounterCritic($repository, $store));
		
		$allies = [
			16
		];

		$enemies = [
			8,
			13
		];

		$recommendations = $recommender->recommend($allies, $enemies, 'mid');
		
		foreach ($recommendations as $recommendation) {
			echo "Name: " . $recommendation['champion']->name . "<br>";
			echo "Score: " . $recommendation['score'] . "<br>";
		}

		return;

		return view('hello');
	}

}
