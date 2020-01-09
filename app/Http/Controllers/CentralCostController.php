<?php


namespace App\Http\Controllers;


use App\CentralCost;
use App\Http\Requests\CreateCentralCostRequest;
use App\Http\Requests\UpdateCentralCostRequest;
use App\Services\CentralCost\CentralCostService;
use App\ValueObject\CreateCentralCost;
use App\ValueObject\UpdateCentralCost;


/**
 * Class CentralCostController
 * @package App\Http\Controllers
 */
class CentralCostController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'central-costs.';

    /**
     * @var CentralCostService
     */
    private $service;

    /**
     * CentralCostController constructor.
     * @param CentralCostService $service
     */
    public function __construct(CentralCostService $service)
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
        $centralCosts = $this->service->all(true);

        return view(self::PREFIX_VIEW . 'index', compact('centralCosts'));
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
     * @param CreateCentralCostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCentralCostRequest $request)
    {
        try{
            $this->service->create(new CreateCentralCost($request));
            return redirect()->route('centralCosts.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('centralCosts.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param CentralCost $centralCost
     * @return \Illuminate\Http\Response
     */
    public function edit(CentralCost $centralCost)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('centralCost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCentralCostRequest $request
     * @param CentralCost $centralCost
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCentralCostRequest $request, CentralCost $centralCost)
    {
        try{
            $this->service->update((new UpdateCentralCost($request)), $centralCost);
            return redirect()->route('centralCosts.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('centralCosts.index')->with('error','عملیات با مشکل مواجه شد');
        }
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
}
