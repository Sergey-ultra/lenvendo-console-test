<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exception\InputException;
use Closure;

class Application
{
    protected $commandMap = [];
    protected static $bootstrappers = [];
    public function __construct()
    {
        foreach (static::$bootstrappers as $bootstrapper) {
            $bootstrapper($this);
        }
    }

    public static function starting(Closure $callback): void
    {
        static::$bootstrappers[] = $callback;
    }

    public function resolve($command): void
    {
        if (is_subclass_of($command, Command::class) && ($commandName = $command::getDefaultName())) {
            $this->commandMap[$commandName] = $command;
        }
    }

    public function getCommandList(): array
    {
        $list = [];
        foreach ($this->commandMap as $command => $class) {
            $list[$command] = $class::getDescription();
        }
        return $list;
    }

    public function run(array $input): array
    {
        [$command, $args, $options] = $this->parseCommand($input);
        if (! in_array($command, array_keys($this->commandMap))) {
            throw new InputException(sprintf('Команда "%s" не найдена', $command));
        }

        (new $this->commandMap[$command]())->call($args);
        return  [$command, $args, $options];
    }

    protected function parseCommand(array $input): array
    {
        $command = $input[0];
        array_shift($input);
        $args = $options = [];
        foreach ($input as $string) {
            if (preg_match('#{(.+?)\}#', $string, $argMatches)) {
                $args = array_merge($args, explode(',', $argMatches[1]));
            }

            if (preg_match('#\[(.+?)\]#', $string, $optionMatches)) {
                $optionsParts = explode('=', $optionMatches[1], 2);
                $value = [$optionsParts[1]];
                if (preg_match('#{(.+?)\}#', $optionsParts[1], $optionValuesMatches)) {
                    $value = explode(',', $optionValuesMatches[1]);
                }

                $options[$optionsParts[0]] = $value;
            }
        }

        return [$command, $args, $options];
    }
}
