<?php

namespace StripJackNaked;

class RandomHandGenerator{

    /**
     * Full deck of number and face cards, numbers replaces with -
     */
    const AVAIL_CARDS = '------------------------------------AAAAJJJJKKKKQQQQ';

    private string $handA;

    private string $handB;

    public function __construct()
    {
        $this->shuffle();
    }

    public function shuffle(): void
    {
        $cards = str_split(RandomHandGenerator::AVAIL_CARDS);
        shuffle($cards);
        $cards = array_chunk($cards, 26);
        $this->handA = implode($cards[0]);
        $this->handB = implode($cards[1]);
    }

    public function getHandB(): string
    {
        return $this->handB;
    }

    public function getHandA(): string
    {
        return $this->handA;
    }
}