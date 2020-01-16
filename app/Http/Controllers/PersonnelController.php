<?php


namespace App\Http\Controllers;


use App\Exports\FilterPersonnelExport;
use App\Http\Requests\CreatePersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Personnel;
use App\Project;
use App\Services\Personnel\PersonnelService;
use App\ValueObject\CreatePersonnel;
use App\ValueObject\UpdatePersonnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


/**
 * Class PersonnelController
 * @package App\Http\Controllers
 */
class PersonnelController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'personnels.';

    /**
     * @var PersonnelService
     */
    private $service;

    /**
     * PersonnelController constructor.
     * @param PersonnelService $service
     */
    public function __construct(PersonnelService $service)
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
        return view(self::PREFIX_VIEW . 'create');
    }

    /**
     * @param CreatePersonnelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePersonnelRequest $request)
    {
        try{
            $this->service->create((new CreatePersonnel($request)));
            return redirect()->route('personnels.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('personnels.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param Personnel $personnel
     * @return \Illuminate\Http\Response
     */
    public function edit(Personnel $personnel)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('personnel'));
    }

    /**
     * @param UpdatePersonnelRequest $request
     * @param Personnel $personnel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePersonnelRequest $request, Personnel $personnel)
    {
        try{
            $this->service->update((new UpdatePersonnel($request)), $personnel);
            return redirect()->route('personnels.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('personnels.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Personnel $personnel
     * @return void
     */
    public function destroy(Personnel $personnel)
    {
        try{
            DB::transaction(function () use ($personnel){
                $personnel->projects()->detach(Project::pluck('id')->toArray());
                $personnel->delete();
            });
            Session::flash('success','عملیات انجام شد');
        } catch (\Exception $exception) {
            Session::flash('error','عملیات با مشکل مواجه شد');
        }
    }

    public function restore($personnel)
    {
        try{
            Personnel::where('id', $personnel)->withTrashed()->restore();
            return redirect()->route('personnels.index')->with('success', 'عملیات انجام شد');
        }catch (\Exception $e) {
            return redirect()->route('personnels.index')->with('error', 'عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function filter(Request $request)
    {
        if ($request->has('export-filter')){
            $filters = (isset($request->filter)) ? $request->filter : PersonnelService::BASIC_FILTERS;
            return Excel::download(new FilterPersonnelExport($request, $filters), 'filter-personnel-report.xlsx');
        }
        $filters = (isset($request->filter)) ? array_merge(['id'], $request->filter) : PersonnelService::BASIC_FILTERS;
        $personnels = $this->service->filter($request, true);

        return view(self::PREFIX_VIEW . 'filter', compact('personnels', 'filters'));
    }

    /**
     * @param $status
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     *
     * Load list of personnel by selected personnel status
     *
     */
    public function list($status)
    {
        return $this->service->personnelsByStatus($status);
    }
}
