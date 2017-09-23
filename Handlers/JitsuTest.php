<?php
    public $player1Cards = array();
	public $player1UsedCards = array();
	public $player2Cards = array();
	public $player2UsedCards = array();
	public $player1Wins = array(
		's' => array(
			'r'=>'',
			'b'=>'',
			'y'=>'',
			'g'=>'',
			'o'=>'',
			'p'=>''
		),
		'w'=> array(
			'r'=>'',
			'b'=>'',
			'y'=>'',
			'g'=>'',
			'o'=>'',
			'p'=>''
		),
		'f'=> array(
			'r'=>'',
			'b'=>'',
			'y'=>'',
			'g'=>'',
			'o'=>'',
			'p'=>''
		)
	);
	public $player2Wins = array(
		's' => array(
			'r'=>'',
			'b'=>'',
			'y'=>'',
			'g'=>'',
			'o'=>'',
			'p'=>''
		),
		'w'=> array(
			'r'=>'',
			'b'=>'',
			'y'=>'',
			'g'=>'',
			'o'=>'',
			'p'=>''
		),
		'f'=> array(
			'r'=>'',
			'b'=>'',
			'y'=>'',
			'g'=>'',
			'o'=>'',
			'p'=>''
		)
	);
	public $addedPercentage = array(
		0=> 100, #noBelt
		1=> 30, #white
		2=> 20, #yellow
		3=> 17, #orange
		4=> 16, #green
		5=> 13, #blue
		6=> 9, #red
		7=> 8, #purple
		8=> 5 #brown
	);
	public $loserAddedPercentage = array(
		0=> 30, #noBelt
		1=> 15, #white
		2=> 10, #yellow
		3=> 9, #orange
		4=> 7, #green
		5=> 7, #blue
		6=> 5, #red
		7=> 5, #purple
		8=> 3 #brown
	);

public function __construct($sensei=false) {
		$this->sensei = $sensei;
		if($sensei) {
			$this->player1 = "Sensei";
		}
	}

	public function setCardsArray($cardsArray, $cardsArray2) {
		$this->cardsArray = $cardsArray;
		$this->cardsArray2 = $cardsArray2;
	}

	public function setPlayer1($player) {
		$this->player1 = $player;
	}

	public function setPlayer2($player) {
		$this->player2 = $player;
	}

	public function dealCards(Array $arrData, Client $objClient) {
		if($this->sensei and $intPlayer != "Sensei") {
			$this->dealCards("Sensei", $dealNum);
		}
		$myCards = ($this->player1 == $intPlayer) ? $this->player1Cards:$this->player2Cards;
		$myUsedCards = ($this->player1 == $intPlayer) ? $this->player1UsedCards:$this->player2UsedCards;
		$x = array();
		$cardsProcessed = 0;
		for($cardsProcessed = 0; $cardsProcessed != $dealNum; $cardsProcessed++) {
			$cardId = array_rand($this->cardsArray2);
			$cardDetails = sprintf("%d|%s", $cardId, implode("|", $this->cardsArray2[$cardId]));
			array_push($myCards, $cardDetails);
			array_push($x, $cardDetails);
		}
		$playerCardsString = implode("%", $x);
		if ($intPlayer != "Sensei") {
			$playerCardsString = implode("%", $x);
			$objClient->sendXt('zm', $waddleRoomId, $deal, $seatID, $playerCardsString);
	}




	public function dealCards($penguin,$dealNum) {
		if($this->sensei and $penguin != "Sensei") {
			$this->dealCards("Sensei", $dealNum);
		}
		$myCards = ($this->player1 == $penguin) ? $this->player1Cards:$this->player2Cards;
		$myUsedCards = ($this->player1 == $penguin) ? $this->player1UsedCards:$this->player2UsedCards;
		$x = array();
		$cardsProcessed = 0;
		for($cardsProcessed = 0; $cardsProcessed != $dealNum; $cardsProcessed++) {
			$cardId = array_rand($this->cardsArray2);

			$cardDetails = sprintf("%d|%s", $cardId, implode("|", $this->cardsArray2[$cardId]));

			array_push($myCards, $cardDetails);
			array_push($x, $cardDetails);
		}
		$playerCardsString = implode("%", $x);
		if ($penguin != "Sensei") {
			$playerCardsString = implode("%", $x);
			$penguin->room->send("%xt%zm%{$penguin->waddleRoom}%deal%{$penguin->seatID}%$playerCardsString%");
		} else {
			$playerCardsString = implode("%", $x);
			$this->player2->send("%xt%zm%{$this->player2->waddleRoom}%deal%0%$playerCardsString%");
		}
		switch ($penguin) {
			case $this->player1:
				$this->player1Cards = $myCards;
				break;
			case $this->player2:
				$this->player2Cards = $myCards;
				break;
		}
	}

?>