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

	public $hand = array(); //Cody - Changed to static to allow access when printing player hands
	
	public $sum = 0;
	var $doneDrawing = false;
	public $name = "";

	function __construct($name = "") {
		$this->name = $name;
	}

	function __toString() {
		return $this->name . ": " . $this->sum . "pts";
	}

	function draw() {
		$c = new Card();
		$this->sum += $c->val;
		$this->hand[] = $c;
	}

	function extraDraw() {
		//returns true if done drawing
		if ($this->sum < 30 || $this->sum < 42 && rand(-4, 10) < (42 - $this->sum)) {
			$this->draw();
			return false;
		}
		return true;
	}

	static function initDraw() {
		for ($i = count(Player::$players); $i < Player::$nPlayers; $i++)
			Player::$players[] = new Player("Player " . ($i + 1));
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

	static function getWinner() {
		$w = array();
		$m = -1;
		foreach (Player::$players as $p) {
			if ($p->sum > $m and $p->sum < 43) {
				$w = array($p);
				$m = $p->sum;
			} elseif ($p->sum == $m)
				$w[] = $p;
		}
		return $w;
	}
}

function demo() {
	/*
	 * Simple demo of the game loop
	 * TODO: delete before submitting
	 */
	$start = microtime();
	Player::$players[] = new Player("Aymeric");
	Player::$players[] = new Player("Chenyu");
	Player::$players[] = new Player("Cody");
	Player::$players[] = new Player("Devin");
	shuffle(Player::$players);
	Player::initDraw();
	Player::doExtraDraws();
	echo "<div id='playerUI'>";//Cody - start of the playerUI
	$i = 1;
	foreach (Player::$players as $p){
		echo "<div id='player'>" . $p;
		echo "<br/><img src='img/player".$i.".jpg' />";
		$i++;
		echo "<div id='cardUI'>";
		foreach($p->hand as $c){ //Cody - intended to print the images of each card drawn by the current player
			$cardImg = $c->getPath();
			echo "<img src='$cardImg'/>";
		}
		echo "\n</div></div><br/>";//Cody - added <div id='player'> (insert info here) </div> for each player
	}
	echo "</div>";//Cody - end of the playerUI
	echo "<br>";
	echo "<div id='winner'>";
	echo "\n\nWinner(s):\n <br/>";
	foreach (Player::getWinner() as $p) echo "$p\n<br/>";
	echo "</div>";
	echo "<br>";
	$time = microtime() - $start;
	session_start();
	$_SESSION["nExecutions"]++;
	$_SESSION["timeSum"] += $time;
	echo "<div id='results'>Played " .$_SESSION["nExecutions"] . " times <br/>";//Cody - start of results
	echo "\nExecuted in ${time}ms.\n<br/>";
	$avg = $_SESSION["timeSum"] / $_SESSION["nExecutions"];
	echo "Average time: ${avg}ms.\n</div>";//Cody - end of results
	echo "<br>";
}

//demo();
?>
