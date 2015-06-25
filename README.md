#Strip Jack Naked:

PHP based solver for the Strip Jack Naked card game. Example usage is below.

```php

$loader = require(__DIR__ . '/vendor/autoload.php');

use StripJackNaked\Player;
use StripJackNaked\RandomHandGenerator;

$hand = new RandomHandGenerator();
$handA = $hand->getHandA();
$handB = $hand->getHandB();

$stripJackNaked = new Player($handA, $handB);
$stripJackNaked->setDebug(false);
$start = microtime(true);

try {
    $stripJackNaked->run();
}catch(Exception $e){
    echo $e->getMessage()."\n";
}

$time = microtime(true) - $start;
echo "Winner - ".$stripJackNaked->getWinningPlayer()."\n";
echo "Ran in ".number_format($time, 5)."ms\n";
echo "Turns - ".$stripJackNaked->getTurns()."\n";
echo "Tricks - ".$stripJackNaked->getTricks()."\n";
