<?php namespace App\Scrapers;

use Goutte\Client;

abstract class AbstractScraper {

	protected $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

	public abstract function scrape();
}