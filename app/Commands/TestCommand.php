<?php

declare(strict_types=1);

namespace App\Commands;

use App\Core\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected static $signature = 'test';
/**
     * The console command description.
     *
     * @var string
     */
    protected static $description = 'test description';
/**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        echo 0 . \PHP_EOL;
    }
}
