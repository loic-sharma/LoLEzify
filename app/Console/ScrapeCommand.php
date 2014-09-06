<?php namespace App\Console;

use Goutte\Client;
use Illuminate\Console\Command;
use App\Scrapers\LoLCounterScraper;
use App\Champion\Model as Champion;
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

		$this->fixMistakes();
	}

	protected function fixMistakes() {
		$annie = Champion::where('name', 'annie')->first();
		$annie->support = true;
		$annie->save();

		$chogath = Champion::where('name', 'cho\'gath')->first();
		$chogath->top = true;
		$chogath->save();

		$jinx = Champion::where('name', 'jinx')->first();
		$jinx->adc = true;
		$jinx->save();

		$kayle = Champion::where('name', 'kayle')->first();
		$kayle->adc = false;
		$kayle->save();

		$khazix = Champion::where('name', 'kha\'zix')->first();
		$khazix->jungler = true;
		$khazix->save();

		$kogmaw = Champion::where('name', 'kog\'maw')->first();
		$kogmaw->jungler = true;
		$kogmaw->save();

		$leona = Champion::where('name', 'leona')->first();
		$leona->adc = false;
		$leona->save();

		$lux = Champion::where('name', 'lux')->first();
		$lux->adc = false;
		$lux->save();

		$yi = Champion::where('name', 'master yi')->first();
		$yi->mid = false;
		$yi->save();

		$varus = Champion::where('name', 'varus')->first();
		$varus->mid = false;
		$varus->save();

	}
}
