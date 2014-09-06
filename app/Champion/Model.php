<?php namespace App\Champion;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'champions';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	 */
	protected $visible = ['name'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	public function getNameAttribute($name) {
		return ucfirst($name);
	}

	public function setNameAttribute($name) {
		$this->attributes['name'] = strtolower($name);
	}

	public function weaknesses() {
		return $this->belongsToMany('App\Champion\Model', 'weaknesses', 'champion_id', 'weakness_id');
	}

	public function strengths() {
		return $this->belongsToMany('App\Champion\Model', 'strengths', 'champion_id', 'strength_id');
	}

	public function mutualistic() {
		return $this->belongsToMany('App\Champion\Model', 'mutualistic', 'champion_id', 'ally_champion_id');
	}

	public function isSameLaneAs(Model $champion) {
		if ($this->top and $champion->top) {
			return true;
		}

		if ($this->mid and $champion->mid) {
			return true;
		}

		if ($this->adc or $this->support) {
			return ($champion->adc or $champion->support);
		}
	}

	public function loses(Model $champion) {
		return $this->relationshipContainsChampion('weaknesses', $champion);
	}

	public function beats(Model $champion) {
		return $this->relationshipContainsChampion('strengths', $champion);
	}

	public function alliesWellWith(Model $champion) {
		return $this->relationshipContainsChampion('mutualistic', $champion);
	}

	protected function relationshipContainsChampion($relationship, Model $needle) {
		foreach ($this->$relationship as $champion) {
			if ($champion->id == $needle->id) {
				return true;
			}
		}

		return false;		
	}
}