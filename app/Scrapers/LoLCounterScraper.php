<?php namespace App\Scrapers;

use App\Champion;

class LoLCounterScraper extends AbstractScraper {

	const CHAMPIONS_URL = 'http://www.lolcounter.com/champions';
	const CHAMPION_URL = 'http://www.lolcounter.com/champions/';

	protected $championIds = [];

	public function scrape() {
		$champions = $this->scrapeChampions();

		foreach ($champions as $champion) {
			$this->scrapeChampion($champion);
		}
	}

	protected function scrapeChampions() {
		$self = $this;
		$crawler = $this->client->request('GET', self::CHAMPIONS_URL);
		
		return $crawler->filter('div.champions a')->each(function($node) {
			$name = strtolower(trim($node->text()));
			$champion = Champion::create([
				'name' => $name
			]);

			$this->championIds[$name] = $champion->id;

			return $champion;
		});
	}

	protected function scrapeChampion($champion) {
		$champion->weaknesses()->sync($this->crawlThroughChampions($champion, 'weak'));
		$champion->strengths()->sync($this->crawlThroughChampions($champion, 'strong'));
		$champion->mutualistic()->sync($this->crawlThroughChampions($champion, 'good'));
		$champion->save();
	}

	protected function crawlThroughChampions($champion, $type) {
		$url = self::CHAMPION_URL . $champion->name . '/' . $type;
		$crawler = $this->client->request('GET', $url);
		$filter = 'div.block3 div.champ-block div.name';

		return $crawler->filter($filter)->each(function($node) {
			$name = trim(strtolower($node->text()));

			return $this->championIds[$name];
		});
	}
}