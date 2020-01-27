<?php


namespace App\Http\Controllers;


use App\Guarantee;
use App\Http\Requests\CreateGaranteeRequest;
use App\Http\Requests\UpdateGuaranteeRequest;
use App\Personnel;
use App\Services\Guarantee\GuaranteeService;
use App\ValueObject\CreateGuarantee;
use App\ValueObject\UpdateGuarantee;
use Illuminate\Http\Request;


/**
 * Class GuaranteeController
 * @package App\Http\Controllers
 */
class GuaranteeController extends Controller
{
    /**
     * prefix of view
     */
    const PREFIX_VIEW = 'guarantees.';

    /**
     * @var GuaranteeService
     */
    private $service;

    /**
     * GuaranteeController constructor.
     * @param $service
     */
    public function __construct(GuaranteeService $service)
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
        $guarantees = $this->service->all(true);
        return view(self::PREFIX_VIEW . 'index', compact('guarantees'));
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
     * Store a newly created resource in storage.
     *
     * @param CreateGaranteeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGaranteeRequest $request)
    {
        try{
            $this->service->create((new CreateGuarantee($request)));
            return redirect()->route('guarantees.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('guarantees.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param Guarantee $guarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(Guarantee $guarantee)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('guarantee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGuaranteeRequest $request
     * @param Guarantee $guarantee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuaranteeRequest $request, Guarantee $guarantee)
    {
        try{
            $this->service->update((new UpdateGuarantee($request)), $guarantee);
            return redirect()->route('guarantees.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('guarantees.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guarantee $guarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guarantee $guarantee)
    {
        try {
            $guarantee->delete();
            return redirect()->route('guarantees.index')->with('success', 'عملیات انجام شد');
        }catch (\Exception $e) {
            return redirect()->route('guarantees.index')->with('error', 'عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Personnel $personnel
     * @return mixed
     */
    public function timesGuaranteeToDedicatedPersonnel(Personnel $personnel)
    {
        $times = $this->service->timesGuaranteeToDedicatedPersonnel($personnel->id);
        return $times;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $guarantees = $this->service->filterByPersonnel($request->personnelId);

        return view(self::PREFIX_VIEW . 'index', compact('guarantees'));
    }
}
