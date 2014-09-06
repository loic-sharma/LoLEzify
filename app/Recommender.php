<?php namespace App;

class Recommender {

	protected $allies = [];
	protected $enemies = [];

	public function setAllies(array $allies) {
		$this->allies = $allies;
	}

	public function setEnemies(array $enemies) {
		$this->enemies = $enemies;
	}

	public function recommend() {
		
	}
}