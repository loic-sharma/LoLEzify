<?php namespace App;

use Illuminate\Database\DatabaseManager as Connection;

class ChampionRepository {

	protected $connection;

	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}
}