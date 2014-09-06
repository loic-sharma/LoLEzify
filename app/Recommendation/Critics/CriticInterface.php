<?php namespace App\Recommendation\Critics;

use App\Champion\Model as Champion;

interface CriticInterface {

	public function update($allies, $enemies, $role);
	public function judge(Champion $champion);
}