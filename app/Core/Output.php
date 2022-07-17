<?php

declare(strict_types=1);

namespace App\Core;

class Output
{
    public static function show(array $array, int $offset = 0): void
    {
        foreach ($array as $el) {
            if ($offset) {
                for ($i = 0; $i <= $offset; $i++) {
                    echo ' ';
                }
            }
            echo '- ' . $el . \PHP_EOL;
        }
    }
}
