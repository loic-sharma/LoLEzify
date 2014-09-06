<?php namespace App\Http\Controllers;

use App\Recommender;
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
		$recommender = new Recommender;

		$recommender->setRole('mid');
		$recommender->setAllies([
			8
		]);
		$recommender->setEnemies([
			13
		]);

		return view('hello');
	}

}
