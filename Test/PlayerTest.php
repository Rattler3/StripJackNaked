<?php

use StripJackNaked\Player;

class PlayerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Player
     */
    protected $player;

    public function setUp() {

        $handA = 'A-QK------Q----KA-----J---';
        $handB = '-JAK----A--Q----J---QJ--K-';

        $this->player = new Player($handA,$handB);
    }

    public function testRun()
    {
        $this->player->run();
    }

    /**
     * @depends testRun
     */
    public function testWinner(){
        $this->player->run();
        $this->assertEquals('A', $this->player->getWinningPlayer());
    }

    /**
     * @depends testRun
     */
    public function testTurns(){
        $this->player->run();
        $this->assertEquals(6913, $this->player->getTurns());
    }

    /**
     * @depends testRun
     */
    public function testTricks(){
        $this->player->run();
        $this->assertEquals(960, $this->player->getTricks());
    }

}
