<?php

declare(strict_types=1);

namespace App\Core;

use http\QueryString;

class Command
{
    protected static $signature;
    protected static $description;
    public static function getDefaultName(): ?string
    {
        return static::$signature;
    }

    public static function getDescription(): ?string
    {
        return static::$description;
    }

    public function call(array $args = [])
    {
        $method = method_exists($this, 'handle') ? 'handle' : '__invoke';
        return call_user_func([$this, $method], $args);
    }
}
