<?php

namespace App\Http\Controllers\Import;

use App\Jobs\ImportProgramData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    /**
     * Import program data and faculty data.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $this->validate($request, [
            'program-data' => 'required',
        ]);

        $path = $request->file('program-data')->store('programs/new');

        ImportProgramData::dispatch(storage_path('app/'.$path));
        $request->session()->flash('program-import-status', 'File was successfully uploaded and will be processed soon.');

        return back();
    }
}
