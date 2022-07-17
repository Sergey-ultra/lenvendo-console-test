<?php

declare(strict_types=1);

namespace App;

use App\Core\Application;
use App\Core\Command;
use ReflectionClass;

class Console
{
    public function load()
    {
        $paths =  __DIR__ . '/Commands';
        $namespace = 'App\Commands\\';
        if (empty($paths)) {
            return;
        }
        $filenames = array_filter(scandir($paths), function (string $item) {

            if (!in_array($item, ['.','..'])) {
                return $item;
            }
        });
        foreach ($filenames as $command) {
            $command = $namespace . str_replace(['/', '.php'], ['\\', ''], $command);

            if (
                is_subclass_of($command, Command::class) &&
                ! (new ReflectionClass($command))->isAbstract()
            ) {
                Application::starting(function ($console) use ($command) {

                    $console->resolve($command);
                });
            }
        }
    }
}
