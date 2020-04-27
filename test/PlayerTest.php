<?php

namespace Test\StripJackNaked;

use PHPUnit\Framework\TestCase;
use StripJackNaked\Player;

class PlayerTest extends TestCase
{
    public function getHands() {

        return [
            // tricks, turns, handA, handB
            [960, 6913, 'A-QK------Q----KA-----J---','-JAK----A--Q----J---QJ--K-'], // Collins 2006:
            [1007, 7157, 'K-KK----K-A-----JAA--Q--J-','---Q---Q-J-----J------AQ--'], // Mann and Wu 2007:
            [1015, 7207, '----Q------A--K--A-A--QJK-','-Q--J--J---QK---K----JA---'], // Nessler 2012:
            [1016, 7225, '--A-Q--J--J---Q--AJ-K---K-','-J-------Q------A--A--QKK-'], // Anderson 2013:
            [1122, 7959, '-J------Q------AAA-----QQ-','K----JA-----------KQ-K-JJK'], // Rucklidge 2014
        ];

    }

    /**
     * @dataProvider getHands
     */
    public function testRun($tricks, $turns, $handA, $handB)
    {
        $player = new Player($handA, $handB);

        $player->run('A');

        $this->assertSame($player->getTricks(), $tricks, 'Tricks do not match');
        $this->assertSame($player->getTurns(), $turns, 'Turns do not match');
    }

    public function testNotEnoughCards()
    {
        $player = new Player('AAA', '---');

        $this->expectException(\Exception::class);

        $player->run();
    }

}
