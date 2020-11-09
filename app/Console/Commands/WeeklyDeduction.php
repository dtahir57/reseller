<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ResellerController;

class WeeklyDeduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:deduction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly 250 Rs Deduction';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reseller = new ResellerController;
        $reseller->weekly_deduction();

        $this->info('Weekly Deduction');
    }
}
