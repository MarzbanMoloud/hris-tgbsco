<?php


namespace App\Http\Controllers;


use App\Exports\FilterPersonnelExport;
use App\Imports\PersonnelsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;


/**
 * Class ExcelController
 * @package App\Http\Controllers
 */
class ExcelController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportFilterPersonnel(Request $request)
    {
        //return Excel::download(new FilterPersonnelExport($request), 'filter-personnel-report.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        try {
            Excel::import(new PersonnelsImport(), $request->file('file_xls'));
            return redirect()->back()->with('success', 'عملیات انجام شد');
        } catch (ValidationException $e) {
            foreach ($e->failures() as $failure) {
                return redirect()->back()->with('error', $failure->errors()[0]);
            }
        }
    }
}
