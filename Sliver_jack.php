<?php
class Card {
	public static $usedCards = array();
	public $suit = 0;
	public $val = 0;

	public static $suits = array("clubs", "diamonds", "hearts", "spades");

	public function getPath() {
		return "cards/" . Card::$suits[$this->suit] . "/" . ($this->val + 1) . ".png";
	}

	public static function initUsedCards() {
		for ($i = 0; $i < 4; $i++) {
			Cards::$usedCards[i] = array();
			for ($j = 0; $j < 13; $j++)
				Cards::$usedCards[i][j] = false;
		}
	}

	function __construct() {
		do {
			$this->suit = rand(0, 3);
			$this->val = rand(0, 12);
		} while (Card::$usedCards[$this->suit][$this->val]);
		Card::$usedCards[$this->suit][$this->val] = true;
	}
}

$c = new Card();
echo $c->getPath(), PHP_EOL;

?>

<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
        <? 
    </body>
</html>