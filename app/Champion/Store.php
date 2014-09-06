<?php namespace App\Champion;

class Store {

	protected $repository;
	protected $loadedIds = [];
	protected $champions = [];

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

	public function preload(array $ids) {
		$ids = $this->removeDuplicateIds($ids);
		$champions = $this->repository->get($ids);

		foreach ($champions as $champion) {
			$this->champions[$champion->id] = $champion;
		}
	}

	protected function removeDuplicateIds(array $ids) {
		$intersection = array_intersect($this->loadedIds, $ids);

		return array_diff($ids, $intersection);
	}

	public function find($id) {
		if (isset($this->champions[$id]) == false) {
			$this->champions[$id] = $this->repository->find($id);
		}

		return $this->champions[$id];
	}

	public function get(array $ids) {
		$this->preload($ids);

		return array_map(function($id) {
			return $this->champions[$id];
		}, $ids);
	}
}