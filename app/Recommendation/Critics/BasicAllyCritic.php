<?php namespace App\Recommendation\Critics;

use App\Champion;

class BasicAllyCritic extends AbstractCritic {

	public function judge(Champion $champion) {
		$score = 0;

		foreach ($this->allies as $ally) {
			if ($champion->alliesWellWith($ally)) {
				$score += ($champion->isSameLaneAs($ally)) ? 1 : 0.2;
			}
		}

		return $score;
	}
}