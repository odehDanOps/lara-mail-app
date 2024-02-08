<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\MailImport;

class MailController extends Controller
{
    /**
     * Display the registration view.
     */
    public function index(): View
    {
        return view('webmail.index');
    }

    /**
     * Send mail.
     */
    public function send(Request $request)
    {
        $file = $request->file('file');
        if ($request->hasFile('file') && $file->isValid()) {
            $extension = $file->getClientOriginalExtension();
            if ($extension === 'csv') {
                try {
                    $collection = Excel::import(new MailImport, $file, null, \Maatwebsite\Excel\Excel::CSV);
                    return redirect()->back();   
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    foreach ($failures as $failure) {
                        logger('Import Error with row:: TRACE :: '.$failure->row());
                        logger('Import Error either heading key (if using heading row concern) or column index:: TRACE :: '.$failure->attribute());
                        logger('Import Error values of the row that has failed:: TRACE :: '.$failure->values());
                        logger('Import Error :: TRACE :: '.$failure->errors());
                    }
                }
            }
        }
    }
}
