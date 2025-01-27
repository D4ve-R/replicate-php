<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace D4veR\Replicate\Commands;

use D4veR\Replicate\Providers\ReplicateServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicate:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Replicate ServiceProvider into your app';

    /**
     * @throws Exception
     */
    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--provider' => ReplicateServiceProvider::class,
        ]);
    }
}