<?php

namespace StripJackNaked;

class Player{

    /**
     * @var string
     */
    private $startHandA;

    /**
     * @var string
     */
    private $startHandB;

    /**
     * @var string
     */
    private $handA;

    /**
     * @var string
     */
    private $handB;

    /**
     * @var int
     */
    private $turns;

    /**
     * @var int
     */
    private $tricks;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var string
     */
    private $winningPlayer;

    /**
     * @param string $handA
     * @param string $handB
     */
    public function __construct($handA, $handB)
    {
        $this->handA = $handA;
        $this->startHandA = $handA;

        $this->handB = $handB;
        $this->startHandB = $handB;

        $this->turns = 0;
        $this->tricks = 0;

        $this->debug = false;
    }

    /**
     * @param string $player
     * @throws \Exception
     */
    public function run($player = 'A')
    {
        $this->validate();

        $handA = str_split($this->handA);
        $handB = str_split($this->handB);
        if($this->getDebug()) {
            echo sprintf("Starting to play with A: %s | B: %s ", $this->handA, $this->handB) . "\n\n";
        }
        $pot = array();
        $handInProgress = 0;
        $cardsToPlay = 1;

        // loop while no hand has not lost
        while(count($handA) != 0 and count($handB) != 0 ){

            while($cardsToPlay > 0){
                if($this->getDebug()) {
                    echo "Player ".$player."\n";
                }
                //Get next card from current player
                if($player == 'A'){
                    $card = array_shift($handA);
                }else{
                    $card = array_shift($handB);
                }

                //if card is null then game is over
                if($card == null){
                    $this->tricks++; // Add one here as the player has to pick up the cards left
                    $this->setWinningPlayer($this->changePlayer($player, false));
                    return true;
                    #throw new Exception(sprintf('Player %s out of cards and has lost.', $player));
                }
                $this->turns++;
                if($this->getDebug()) {
                    echo "\t plays card ".$card."\n";
                }
                // add the card to pot
                $pot[] = $card;
                if($card == '-'){
                    if($handInProgress == 1){
                        //stick with same player but reduce number to find by one until 0
                        $cardsToPlay--;
                        // When 0 award pot to the opposite player and rest
                        if($cardsToPlay == 0){
                            if($this->getDebug()) {
                                echo "\t pot goes to player ".$this->changePlayer($player, false)."\n";
                            }
                            $this->tricks++;
                            if($player == 'A'){
                                $handB = array_merge($handB, $pot);
                            }else{
                                $handA = array_merge($handA, $pot);
                            }
                            $pot = array();
                            $handInProgress = 0;
                            $cardsToPlay = 1;
                            $player = $this->changePlayer($player, $this->getDebug());
                        }
                    }else{
                        $player = $this->changePlayer($player, $this->getDebug());
                        $handInProgress = 0;
                    }
                }else{
                    //Royal card has been picked get value of card
                    $worth = $this->cardWorth($card);
                    $handInProgress = 1;
                    $cardsToPlay = $worth;
                    //switch player and keep playing this hand
                    $player = $this->changePlayer($player, $this->getDebug());
                    if($this->getDebug()) {
                        echo "\t cards to play " . $worth . "\n";
                    }
                }
            }
        }

    }

    /**
     * @param $player
     * @param bool $verbose
     * @return string
     */
    private function changePlayer($player, $verbose=true){
        if($verbose) echo " \t change player from {$player}";

        if ($player == 'A') {
            $player = 'B';
        } else {
            $player = 'A';
        }

        if($verbose) echo " to {$player}\n";

        return $player;
    }

    /**
     * @param string $card
     * @return int|null
     */
    private function cardWorth($card){

        $value = null;

        switch($card){
            case 'A':
                $value = 4;
                break;
            case 'K':
                $value = 3;
                break;
            case 'Q':
                $value = 2;
                break;
            case 'J':
                $value = 1;
                break;
        }

        return $value;

    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function validate()
    {
        // Check enough cards are present
        if(strlen($this->handA) != 26 or strlen($this->handB) != 26 ){
            throw new \Exception(sprintf('Hands do not contain 26 cards each A:%s B:%s', strlen($this->handA), strlen($this->handB)));
        }
    }

    /**
     * @return int
     */
    public function getTurns()
    {
        return $this->turns;
    }

    /**
     * @return int
     */
    public function getTricks()
    {
        return $this->tricks;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartHandB()
    {
        return $this->startHandB;
    }

    /**
     * @return string
     */
    public function getStartHandA()
    {
        return $this->startHandA;
    }

    /**
     * @return string
     */
    public function getWinningPlayer()
    {
        return $this->winningPlayer;
    }

    /**
     * @param string $winningPlayer
     * @return $this
     */
    private function setWinningPlayer($winningPlayer)
    {
        $this->winningPlayer = $winningPlayer;
        return $this;
    }



}
