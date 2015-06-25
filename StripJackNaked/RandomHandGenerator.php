<?php

namespace StripJackNaked;

class RandomHandGenerator{

    /**
     * Full deck of number and face cards, numbers replaces with -
     */
    const AVAIL_CARDS = '------------------------------------AAAAJJJJKKKKQQQQ';

    /**
     * @var string
     */
    private $handA;
    /**
     * @var string
     */
    private $handB;

    public function __construct(){
        $this->shuffle();
    }

    /**
     * @return array
     */
    public function shuffle()
    {
        $cards = str_split(RandomHandGenerator::AVAIL_CARDS);
        shuffle($cards);
        $cards = array_chunk($cards, 26);
        $this->handA = implode($cards[0]);
        $this->handB = implode($cards[1]);
    }

    /**
     * @return string
     */
    public function getHandB()
    {
        return $this->handB;
    }

    /**
     * @return string
     */
    public function getHandA()
    {
        return $this->handA;
    }



}