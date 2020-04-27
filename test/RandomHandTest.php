<?php

namespace Test\StripJackNaked;

use PHPUnit\Framework\TestCase;
use StripJackNaked\RandomHandGenerator;

class RandomHandTest extends TestCase
{

    public function testHand(){

        $deck = new RandomHandGenerator();

        $this->assertEquals(26, strlen($deck->getHandA()) );
        $this->assertEquals(26, strlen($deck->getHandB()) );

    }

    public function testCards(){

        $deck = new RandomHandGenerator();

        $cards = array_merge(
            str_split($deck->getHandA()),
            str_split($deck->getHandB())
        );

        $this->assertNotEmpty($cards);
        sort($cards);
        $this->assertEquals('------------------------------------AAAAJJJJKKKKQQQQ', implode($cards));

    }

}
