<?php namespace App\Recommendation;

use App\Champion\Store;
use App\Champion\Repository;
use App\Recommendation\Critics\CriticInterface;

class Recommender {

	protected $repository;
	protected $store;

	protected $critics = [];

	public function __construct(Repository $repository, Store $store) {
		$this->repository = $repository;
		$this->store = $store;
	}

	public function addCritic(CriticInterface $critic) {
		array_push($this->critics, $critic);
	}

	public function recommend(array $allies, array $enemies, $role, $playerName = null) {
		$this->store->preload(array_merge($allies, $enemies));

		$recommendations = [];
		$possibilities = $this->repository->findPossibilities($allies, $enemies, $role);

		$allies = $this->store->get($allies);
		$enemies = $this->store->get($enemies);

		foreach ($this->critics as $critic) {
			$critic->update($allies, $enemies, $role);

			foreach ($possibilities as $id) {
				$champion = $this->store->find($id);
				$score = $critic->judge($champion);

				if ( ! isset($recommendations[$id])) {
					$recommendations[$id] = 0;
				}

				$recommendations[$id] += $score;
			}
		}

		return $this->prepareRecommendations($recommendations);
	}

	protected function prepareRecommendations($recommendations) {
		asort($recommendations);

		$recommendations = array_reverse($recommendations, true);
		$preparedRecommendations = [];

		foreach ($recommendations as $championId => $score) {
			if (count($preparedRecommendations) >= 5 and $score < 0) {
				break;
			}

			array_push($preparedRecommendations, [
				'champion' => $this->store->find($championId),
				'score' => $score
			]);
		}

		return $preparedRecommendations;
	}
}