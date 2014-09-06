<?php namespace App\Recommendation\Critics;

use App\Champion\Model as Champion;

class CounterCritic extends AbstractCritic {

	protected $enemyCounterCount = [];

	public function update($allies, $enemies, $role) {
		parent::update($allies, $enemies, $role);

		foreach ($enemies as $enemy) {
			// Flatten the enemy's weaknesses to an array of ids.
			$weaknesses = [];

			foreach ($enemy->weaknesses as $weakness) {
				array_push($weaknesses, $weakness->id);
			}

			// Now count how many allies counter the enemy.
			$count = 0;

			foreach ($allies as $ally) {
				if (in_array($ally->id, $weaknesses)) {
					++$count;
				}
			}

			$this->enemyCounterCount[$enemy->id] = $count;
		}
	}

	public function judge(Champion $champion) {
		$score = 0;

		foreach ($this->enemies as $enemy) {
			$counterCount = $this->enemyCounterCount[$enemy->id];

			if ($counterCount == 0) {
				if ($champion->beats($enemy)) {
					$score += ($champion->isSameLaneAs($enemy)) ? 3 : 0.5;
				}
			}
		}

		return $score;
	}
}