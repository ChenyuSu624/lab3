<?php
class Card {
	public static $usedCards = null;
	public static $suits = array("clubs", "diamonds", "hearts", "spades");

	public $suit = 0;
	public $val = 0;

	public function getPath() {
		return "cards/" . Card::$suits[$this->suit] . "/" . ($this->val + 1) . ".png";
	}

	public static function initUsedCards() {
		for ($i = 0; $i < 4; $i++) {
			Card::$usedCards[] = array();
			for ($j = 0; $j < 13; $j++)
				Card::$usedCards[$i][] = false;
		}
	}

	function __construct() {
		if (Card::$usedCards == null) Card::initUsedCards();
		do {
			$this->suit = rand(0, 3);
			$this->val = rand(0, 12);
		} while (Card::$usedCards[$this->suit][$this->val]);
		Card::$usedCards[$this->suit][$this->val] = true;
	}

	static function draw($n=1) {
		$cards = array();
		for (; $i > 0; $i--)
			$cards[] = new Card();
	}
}

$c = new Card();
echo $c->getPath(), PHP_EOL;

?>
