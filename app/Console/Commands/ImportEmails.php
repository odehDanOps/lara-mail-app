<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-emails {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import emails from a file into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File '$filePath' does not exist.");
            return;
        }

        $this->info('Starting email import...');

        $startTime = microtime(true);
        $imported = 0;
        $errors = 0;
        
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($email = fgets($handle)) !== false) {
                $email = trim($email); // Remove whitespace

                // Validate email format (optional)
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    try {
                        DB::table('emails')->insert(['email' => $email]);
                        $imported++;
                    } catch (\Exception $e) {
                        $this->error("Error importing email '$email': " . $e->getMessage());
                        $errors++;
                    }
                } else {
                    $this->warn("Invalid email format: '$email'");
                }
            }

            fclose($handle);
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;

        $this->info("Import completed. Emails imported: $imported, Errors: $errors");
        $this->info("Total time taken: " . gmdate("H:i:s", $totalTime));
    }
}
