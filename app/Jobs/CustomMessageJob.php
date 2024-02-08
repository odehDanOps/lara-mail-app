<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomMessageMail;

class CustomMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $mobileNumber;
    protected $placeOfAssignment;

    /**
     * Create a new job instance.
     */
    public function __construct($name, $email, $mobileNumber, $placeOfAssignment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
        $this->placeOfAssignment = $placeOfAssignment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger(self::class . ' ::: Sending email :::'. $this->email);
        Mail::to($this->email)->send(
            new CustomMessageMail($this->name, $this->email, $this->mobileNumber, $this->placeOfAssignment)
        );
        logger(self::class . ' ::: Email sent.');
    }
}
