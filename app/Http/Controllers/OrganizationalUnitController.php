<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreateOrganizationalUnitRequest;
use App\OrganizationalUnit;
use App\Services\OrganizationalUnit\OrganizationalUnitService;
use App\ValueObject\CreateOrganizationalUnit;
use App\ValueObject\UpdateOrganizationalUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


/**
 * Class OrganizationalUnitController
 * @package App\Http\Controllers
 */
class OrganizationalUnitController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'organizational-units.';

    /**
     * @var OrganizationalUnitService
     */
    private $service;

    /**
     * OrganizationalUnitController constructor.
     * @param OrganizationalUnitService $service
     */
    public function __construct(OrganizationalUnitService $service)
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
        $organizationalUnits = $this->service->all(true);

        return view(self::PREFIX_VIEW . 'index', compact('organizationalUnits'));
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
     * @param CreateOrganizationalUnitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrganizationalUnitRequest $request)
    {
        try{
            $this->service->create((new CreateOrganizationalUnit($request)));
            return redirect()->route('organizationalUnits.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('organizationalUnits.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param OrganizationalUnit $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationalUnit $organizationalUnit)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('organizationalUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param OrganizationalUnit $organizationalUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationalUnit $organizationalUnit)
    {
        try{
            $this->service->update((new UpdateOrganizationalUnit($request)) ,$organizationalUnit);
            return redirect()->route('organizationalUnits.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('organizationalUnits.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OrganizationalUnit $organizationalUnit
     * @return void
     */
    public function destroy(OrganizationalUnit $organizationalUnit)
    {
        try{
            $organizationalUnit->delete();
            Session::flash('success','عملیات انجام شد');
        } catch (\Exception $exception) {
            Session::flash('error','عملیات با مشکل مواجه شد');
        }
    }
}
