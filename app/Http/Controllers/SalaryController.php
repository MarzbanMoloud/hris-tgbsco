<?php


namespace App\Http\Controllers;


use App\Personnel;
use App\Salary;
use App\Services\Personnel\PersonnelService;
use App\Services\Salary\SalaryService;
use App\ValueObject\CreateSalary;
use Illuminate\Http\Request;


/**
 * Class SalaryController
 * @package App\Http\Controllers
 */
class SalaryController extends Controller
{
    /**
     * prefix of view
     */
    const PREFIX_VIEW = 'salaries.';

    /**
     * @var SalaryService
     */
    private $service;

    /**
     * SalaryController constructor.
     * @param SalaryService $service
     */
    public function __construct(SalaryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels = $this->service->all(true);
        return view(self::PREFIX_VIEW . 'index', compact('personnels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->service->create((new CreateSalary($request)));
            return redirect()->route('salaries.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){dd($e->getMessage());
            return redirect()->route('salaries.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function filter(Request $request)
    {
        $filters = (isset($request->filter)) ? array_merge(['id'], $request->filter) : PersonnelService::BASIC_FILTERS;
        $personnels = $this->service->filter($request, true);

        return view(self::PREFIX_VIEW . 'filter', compact('personnels', 'filters'));
    }

    /**
     * @param Personnel $personnel
     * @return mixed
     */
    public function amounts(Personnel $personnel)
    {
        return Salary::where('personnel_id', $personnel->id)
            ->first();
    }
}
