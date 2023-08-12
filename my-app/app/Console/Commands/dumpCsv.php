<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\EnrollController;
use Illuminate\Console\Command;

/**
 * @property EnrollController $enrollController
 */
class dumpCsv extends Command
{
    public function __construct(EnrollController $enrollController)
    {
        parent::__construct();
        $this->enrollController = $enrollController;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->enrollController->dump_csv();
    }
}
