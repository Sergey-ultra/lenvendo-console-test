<?php

use App\Core\Application;
use App\Console;
use App\Core\Exception\InputException;
use App\Core\Output;

require __DIR__.'/vendor/autoload.php';


array_shift($argv);

$console = new Console();
$console->load();

$app = new Application();

try {
    if (in_array('{help}', $argv)) {
        foreach ($app->getCommandList() as $command => $description) {
            echo $command . ' ' . $description . \PHP_EOL;
        }
    } else {
        $commandDTO = $app->run($argv);
        echo 'Called command: ' . $commandDTO->command . \PHP_EOL;
        if (!empty($commandDTO->args)) {
            echo \PHP_EOL . 'Arguments: ' . \PHP_EOL;
            Output::show($commandDTO->args);
        }

        if (!empty($commandDTO->options)) {
            echo \PHP_EOL . 'Options: ' . \PHP_EOL;

            foreach ($commandDTO->options as $key => $value) {
                echo '- ' . $key . \PHP_EOL;
                Output::show($value, 2);
            }
        }
    }
} catch (InputException $e) {
    echo $e->getMessage();
}










