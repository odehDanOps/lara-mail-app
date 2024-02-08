<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Jobs\CustomMessageJob;


class MailImport implements ToCollection, WithValidation, WithChunkReading
{

	/**
     * @param Collection $rows
     *
     * @return null
     */
    public function collection(Collection $rows)
    {
		foreach ($rows as $row) 
        {
			$name = \trimFilterString($row[1], \SanitizeStringType::SPECIAL_CHARACTER);
			$email = \trimFilterString($row[2]);
			$mobileNumber = \trimFilterString($row[3], \SanitizeStringType::NUMERIC);
			$placeOfAssignment = \trimFilterString($row[4], \SanitizeStringType::SPECIAL_CHARACTER);
			CustomMessageJob::dispatch($name, $email, $mobileNumber, $placeOfAssignment);
		}
    }


	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
	public function rules(): array
    {
        return [];
    }

	/**
     * Chunk size to mitigate this increase in memory usage
     *
     * @return int
     */
	public function chunkSize(): int
    {
        return 100;
    }
}