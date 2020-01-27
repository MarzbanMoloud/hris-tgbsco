<?php


namespace App\Http\Controllers;


use App\Help;
use App\Http\Requests\CreateHelpRequest;
use App\Http\Requests\UpdateHelpRequest;
use App\Personnel;
use App\Services\Help\HelpService;
use App\ValueObject\CreateHelp;
use App\ValueObject\UpdateHelp;
use Illuminate\Http\Request;


/**
 * Class HelpController
 * @package App\Http\Controllers
 */
class HelpController extends Controller
{
    /**
     * prefix of view
     */
    const PREFIX_VIEW = 'helps.';

    /**
     * @var HelpService
     */
    private $service;

    /**
     * HelpController constructor.
     * @param HelpService $service
     */
    public function __construct(HelpService $service)
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
        $helps = $this->service->all(true);
        return view(self::PREFIX_VIEW . 'index', compact('helps'));
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
     * @param CreateHelpRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHelpRequest $request)
    {
        try{
            $this->service->create((new CreateHelp($request)));
            return redirect()->route('helps.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('helps.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param Help $help
     * @return \Illuminate\Http\Response
     */
    public function edit(Help $help)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('help'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHelpRequest $request
     * @param Help $help
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHelpRequest $request, Help $help)
    {
        try{
            $this->service->update((new UpdateHelp($request)), $help);
            return redirect()->route('helps.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('helps.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Help $help
     * @return \Illuminate\Http\Response
     */
    public function destroy(Help $help)
    {
        try {
            $help->delete();
            return redirect()->route('helps.index')->with('success', 'عملیات انجام شد');
        }catch (\Exception $e) {
            return redirect()->route('helps.index')->with('error', 'عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Personnel $personnel
     * @return mixed
     */
    public function timesHelpToDedicatedPersonnel(Personnel $personnel)
    {
        $times = $this->service->timesHelpToDedicatedPersonnel($personnel->id);
        return $times;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $helps = $this->service->filterByPersonnel($request->personnelId);

        return view(self::PREFIX_VIEW . 'index', compact('helps'));
    }
}
