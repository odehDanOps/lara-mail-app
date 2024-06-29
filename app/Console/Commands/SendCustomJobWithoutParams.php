<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\CustomJobWithoutParamsJob;

class SendCustomJobWithoutParams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-custom-job-without-params';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails from database using queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting email sending...');

        $chunkSize = 1000; // Adjust chunk size as needed
        $emails = DB::table('emails')->where('status', 0)->limit(9000)->cursor()->chunk($chunkSize);

        foreach ($emails as $chunk) {
            foreach ($chunk as $email) {
                sleep(2);
                dispatch(new CustomJobWithoutParamsJob($email->id, $email->email))->delay(now()->addMinutes(10));
            }
        }

        $this->info('Emails queued for sending.');
    }
}
