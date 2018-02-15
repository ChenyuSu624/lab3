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
		for (; $n > 0; $n--)
			$cards[] = new Card();
		return $cards;
	}
}

class Player {
	public static $nPlayers = 4;
	public static $players = array();

	public $hand = array();
	public $sum = 0;
	var $doneDrawing = false;

	function draw() {
		$c = new Card();
		$this->sum += $c->val;
		$hand[] = $c;
	}

	function extraDraw() {
		//returns true if done drawing
		if ($this->sum < 30 || $this->sum < 42 && rand(-2, 10) < (42 - $this->sum)) {
			$this->draw();
			return false;
		}
		return true;
	}

	static function initDraw() {
		for ($i = 0; $i < Player::$nPlayers; $i++)
			Player::$players[] = new Player();
		foreach (Player::$players as $p) {
			for ($i = 0; $i < 3; $i++)
				$p->draw();
		}
	}

	static function doExtraDraws() {
		$stillDrawing = Player::$nPlayers;
		while ($stillDrawing > 0) {
			for ($i = 0; $i < count(Player::$players); $i++) {
				$p = Player::$players[$i];
				if ($p->doneDrawing)
					continue;
				$p->doneDrawing = $p->extraDraw();
				if ($p->doneDrawing) $stillDrawing--;
			}
		}
	}
}

Player::initDraw();
Player::doExtraDraws();
foreach (Player::$players as $p) echo "sum: $p->sum\n";
?>
