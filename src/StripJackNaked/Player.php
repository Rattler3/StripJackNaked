<?php

namespace StripJackNaked;

class Player{

    private string $startHandA;

    private string $startHandB;

    private string $handA;

    private string $handB;

    private int $turns;

    private int $tricks;

    private bool $debug;

    private string $winningPlayer;

    public function __construct(string $handA, string $handB)
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
     * @throws \Exception
     */
    public function run(string $player = 'A'): bool
    {
        $this->validate();

        $handA = str_split($this->handA);
        $handB = str_split($this->handB);
        if($this->getDebug()) echo sprintf("Starting to play with A: %s | B: %s ", $this->handA, $this->handB) . PHP_EOL;

        $pot = [];
        $handInProgress = 0;
        $cardsToPlay = 1;

        // loop while no hand has not lost
        while(count($handA) != 0 and count($handB) != 0 ){

            // while there are cards to be played
            while($cardsToPlay > 0){
                if($this->getDebug()) echo "Player ".$player.PHP_EOL;

                //Get next card from current player
                if($player == 'A'){
                    $card = array_shift($handA);
                }else{
                    $card = array_shift($handB);
                }

                $this->turns++;

                //if card is null then game is over
                if($card == null || count($handA) == 0 || count($handB) == 0){
                    $this->tricks++; // Add one here as the player has to pick up the cards left
                    if($this->getDebug()) echo "\t increase tricks at end {$this->tricks}".PHP_EOL;
                    $this->setWinningPlayer($this->changePlayer($player));
                    return true;
                }

                if($this->getDebug()) echo "\t increase turns {$this->turns}".PHP_EOL;

                if($this->getDebug()) echo "\t plays card ".$card.PHP_EOL;

                // add the card to pot
                $pot[] = $card;
                if($card == '-'){
                    if($handInProgress == 1){
                        //stick with same player but reduce number to find by one until 0
                        $cardsToPlay--;
                        // When 0 award pot to the opposite player and rest
                        if($cardsToPlay == 0){
                            if($this->getDebug()) echo "\t pot goes to player ".$this->changePlayer($player). PHP_EOL;

                            if($player == 'A'){
                                $handB = array_merge($handB, $pot);
                            }else{
                                $handA = array_merge($handA, $pot);
                            }
                            $this->tricks++;
                            if($this->getDebug()) echo "\t increase tricks {$this->tricks}".PHP_EOL;
                            $pot = [];
                            $handInProgress = 0;
                            $cardsToPlay = 1;
                            $player = $this->changePlayer($player);
                        }
                    }else{
                        $player = $this->changePlayer($player);
                        $handInProgress = 0;
                    }
                }else{
                    //Royal card has been picked get value of card
                    $worth = $this->cardWorth($card);
                    $handInProgress = 1;
                    $cardsToPlay = $worth;
                    //switch player and keep playing this hand
                    $player = $this->changePlayer($player);
                    if($this->getDebug()) echo "\t cards to play " . $worth . PHP_EOL;
                }
            }
        }
        return false;
    }

    private function changePlayer(string $player): string
    {
        if($this->getDebug()) echo " \t change player from {$player}";

        if ($player == 'A') {
            $player = 'B';
        } else {
            $player = 'A';
        }

        if($this->getDebug()) echo " to {$player}\n";

        return $player;
    }

    private function cardWorth(string $card): ?int
    {
        $values = ['A' => 4, 'K' => 3, 'Q' => 2, 'J' => 1];
        return $values[$card];
    }

    /**
     * @throws \Exception
     */
    private function validate(): void
    {
        // Check enough cards are present
        if(strlen($this->handA) != 26 or strlen($this->handB) != 26 ){
            throw new \Exception(sprintf('Hands do not contain 26 cards each A:%s B:%s', strlen($this->handA), strlen($this->handB)));
        }
    }

    public function getTurns(): int
    {
        return $this->turns;
    }

    public function getTricks(): int
    {
        return $this->tricks;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    public function getStartHandB(): string
    {
        return $this->startHandB;
    }

    public function getStartHandA(): string
    {
        return $this->startHandA;
    }

    public function getWinningPlayer(): string
    {
        return $this->winningPlayer;
    }

    private function setWinningPlayer(string $winningPlayer): self
    {
        $this->winningPlayer = $winningPlayer;
        return $this;
    }
}
