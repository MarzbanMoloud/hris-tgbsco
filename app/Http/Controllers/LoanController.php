<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreateLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Loan;
use App\Personnel;
use App\Services\Loan\LoanService;
use App\ValueObject\CreateLoan;
use App\ValueObject\UpdateLoan;
use Illuminate\Http\Request;


/**
 * Class LoanController
 * @package App\Http\Controllers
 */
class LoanController extends Controller
{
    /**
     * prefix of view
     */
    const PREFIX_VIEW = 'loans.';

    /**
     * @var LoanService
     */
    private $service;

    /**
     * LoanController constructor.
     * @param LoanService $service
     */
    public function __construct(LoanService $service)
    {
        $this->service = $service;
        $this->middleware('role:admin|normal')->except(['index', 'filter']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = $this->service->all(true);
        return view(self::PREFIX_VIEW . 'index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(self::PREFIX_VIEW . 'create');
    }

    /**
     * @param CreateLoanRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateLoanRequest $request)
    {
        try{
            $this->service->create((new CreateLoan($request)));
            return redirect()->route('loans.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('loans.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param Loan $loan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Loan $loan)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('loan'));
    }

    /**
     * @param UpdateLoanRequest $request
     * @param Loan $loan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        try{
            $this->service->update((new UpdateLoan($request)), $loan);
            return redirect()->route('loans.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('loans.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Loan $loan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Loan $loan)
    {
        try {
            $loan->delete();
            return redirect()->route('loans.index')->with('success', 'عملیات انجام شد');
        }catch (\Exception $e) {
            return redirect()->route('loans.index')->with('error', 'عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Personnel $personnel
     * @return mixed
     */
    public function timesLoanToDedicatedPersonnel(Personnel $personnel)
    {
        $times = $this->service->timesLoanToDedicatedPersonnel($personnel->id);
        return $times;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $loans = $this->service->filterByPersonnel($request->personnelId);

        return view(self::PREFIX_VIEW . 'index', compact('loans'));
    }
}
