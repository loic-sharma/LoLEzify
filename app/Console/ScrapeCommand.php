<?php namespace App\Console;

use Goutte\Client;
use Illuminate\Console\Command;
use App\Scrapers\LoLCounterScraper;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ScrapeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lol:scrape';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Scrape the LoLCounter website.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		(new LoLCounterScraper(new Client))->scrape();
	}

}
