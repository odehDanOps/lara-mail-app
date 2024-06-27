<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Mail\CustomJobWithoutParamsMail;


class CustomJobWithoutParamsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct($id, $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $id = $this->id;
        $email = $this->email;
        logger(self::class . ' ::: Sending email:' .$email);
        DB::transaction(function () use ($id, $email) {
            Mail::to($this->email)->queue(new CustomJobWithoutParamsMail());
            DB::table('emails')->where('id', $this->id)->update(['status' => 1]);
        });
        logger(self::class . ' ::: Email sent.');
    }
}
