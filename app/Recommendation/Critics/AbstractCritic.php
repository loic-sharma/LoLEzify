<?php namespace App\Recommendation\Critics;

use App\Champion;
use App\Champion\Store;
use App\Champion\Repository;

abstract class AbstractCritic implements CriticInterface {

	protected $repository;
	protected $store;

	protected $allies = [];
	protected $enemies = [];
	protected $role;

	public function __construct(Repository $repository, Store $store) {
		$this->repository = $repository;
		$this->store = $store;
	}

	public function update($allies, $enemies, $role) {
		$this->allies = $allies;
		$this->enemies = $enemies;
		$this->role = $role;
	}
}