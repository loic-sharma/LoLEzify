<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model {

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
		return $this->belongsToMany('App\Champion', 'weaknesses', 'champion_id', 'weakness_id');
	}

	public function strengths() {
		return $this->belongsToMany('App\Champion', 'strengths', 'champion_id', 'strength_id');
	}

	public function mutualistic() {
		return $this->belongsToMany('App\Champion', 'mutualistic', 'champion_id', 'ally_champion_id');
	}
}