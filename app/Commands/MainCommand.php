<?php

declare(strict_types=1);

namespace App\Commands;

use App\Core\Command;

class MainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected static $signature = 'main';
/**
     * The console command description.
     *
     * @var string
     */
    protected static $description = 'Main Command';
/**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        echo 'test' . \PHP_EOL;
    }
}
