<?php

declare(strict_types=1);

namespace App\Core\DTO;


class CommandDTO
{
    public function __construct(
        public string $command,
        public array $args,
        public array $options
    ){}
}