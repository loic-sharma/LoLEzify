<?php namespace App\Recommendation\Critics;

use App\Champion;

class BasicEnemyCritic extends AbstractCritic {

	public function judge(Champion $champion) {
		$score = 0;

		foreach ($this->enemies as $enemy) {
			if ($champion->beats($enemy)) {
				$score += ($champion->isSameLaneAs($enemy)) ? 1 : 0.5;
			}
			elseif ($enemy->beats($champion)) {
				$score -= ($champion->isSameLaneAs($enemy)) ? 2 : 0.5;
			}
		}

		return $score;
	}
}