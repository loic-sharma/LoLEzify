<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'champions';

	public function setNameAttribute($name) {
		$this->attributes['name'] = strtolower($name);
	}

	public function weaknesses() {
		return $this->belongsToMany('Champion', 'weaknesses', 'champion_id', 'weakness_id');
	}

	public function setWeaknessesAttribute(array $champions) {
		$ids = $this->transformChampionsToIds($champions);

		$this->weaknesses()->sync($ids);
	}

	public function strengths() {
		return $this->belongsToMany('Champion', 'strengths', 'champion_id', 'strength_id');
	}

	public function setStrengthsAttribute(array $champions) {
		$ids = $this->transformChampionsToIds($champions);

		$this->strengths()->sync($ids);
	}

	public function mutualistic() {
		return $this->belongsToMany('Champion', 'mutualistic', 'champion_id', 'ally_champion_id');
	}

	public function setMutualisticAttribute(array $champions) {
		$ids = $this->transformChampionsToIds($champions);

		$this->mutualistic()->sync($ids);
	}

	protected function transformChampionsToIds(array $champions) {
		if (count($champions) > 0) {
			if (is_int($champions[0])) {
				return $champions;
			}
			elseif (is_string($champions[0])) {
				$champions = $this->where('name', $champions)->get();
			}
		}

		$ids = [];

		foreach ($champions as $champion) {
			if ($champion instanceof Champion) {
				$ids += $champion->id;
			}
		}

		return $ids;
	}
}