<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use App\Services\Project\ProjectService;
use App\ValueObject\CreateProject;
use Illuminate\Support\Facades\Session;


/**
 * Class ProjectController
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'projects.';

    /**
     * @var ProjectService
     */
    private $service;

    /**
     * ProjectController constructor.
     * @param ProjectService $service
     */
    public function __construct(ProjectService $service)
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
        $projects = $this->service->all(true);

        return view(self::PREFIX_VIEW . 'index', compact('projects'));
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
     * @param CreateProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProjectRequest $request)
    {
        try{
            $this->service->create(new CreateProject($request));
            return redirect()->route('projects.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('projects.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Project $project)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('project'));
    }

    /**
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try{
            $this->service->update((new UpdateProject($request)), $project);
            return redirect()->route('projects.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('projects.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return void
     */
    public function destroy(Project $project)
    {
        try{
            $project->delete();
            Session::flash('success','عملیات انجام شد');
        } catch (\Exception $exception) {
            Session::flash('error','عملیات با مشکل مواجه شد');
        }
    }
}
