<?php namespace App\Champion;

use DB;

class Repository {

	public function find($id) {
		return Model::find($id);
	}

	public function get(array $ids) {
		return Model::whereIn('id', $ids)->get();
	}

	public function findPlayerChampions($player) {
		return [];
	}

	public function findPossibilities(array $enemies, array $allies, $role = null) {
		$possibilities = DB::table('champions')
			->join('strengths', 'champions.id', '=', 'strengths.champion_id')
			->where('champions.' . $role, '=', '1')
			->whereIn('strengths.strength_id', $enemies)
			->select('champions.id')
			->get();

		$possibilities += DB::table('champions')
			->join('mutualistic', 'champions.id', '=', 'mutualistic.champion_id')
			->where('champions.' . $role, '=', '1')
			->whereIn('mutualistic.ally_champion_id', $allies)
			->select('champions.id')
			->get();

		return array_unique(array_pluck($possibilities, 'id', null));
	}
}