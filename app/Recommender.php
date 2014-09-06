<?php namespace App;

use DB;

class Recommender {

	protected $role;
	protected $allies = [];
	protected $enemies = [];

	protected $internalScore = [];

	public function setRole($role) {
		$this->role = $role;
	}

	public function setAllies(array $allies) {
		$this->allies = $allies;
	}

	public function setEnemies(array $enemies) {
		$this->enemies = $enemies;
	}

	public function recommend() {
		$possibilities = $this->findPossibilities();


	}

	protected function findPossibilities() {
		$possibilities = DB::table('champions')
			->join('strengths', 'champions.id', '=', 'strengths.champion_id')
			->where('champions.' . $this->role, '=', '1')
			->whereIn('strengths.strength_id', $this->enemies)
			->select('champions.id')
			->get();

		$possibilities += DB::table('champions')
			->join('mutualistic', 'champions.id', '=', 'mutualistic.champion_id')
			->where('champions.' . $this->role, '=', '1')
			->whereIn('mutualistic.ally_champion_id', $this->allies)
			->select('champions.id')
			->get();

		return array_unique(array_pluck($possibilities, 'id', null));
	}
}