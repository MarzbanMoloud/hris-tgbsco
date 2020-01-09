<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Job;
use App\Services\Job\JobService;
use App\ValueObject\CreateJob;
use App\ValueObject\UpdateJob;
use Illuminate\Support\Facades\Session;


/**
 * Class JobController
 * @package App\Http\Controllers
 */
class JobController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'jobs.';

    /**
     * @var JobService
     */
    private $service;

    /**
     * JobController constructor.
     * @param JobService $service
     */
    public function __construct(JobService $service)
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
        $jobs = $this->service->all(true);

        return view(self::PREFIX_VIEW . 'index', compact('jobs'));
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
     * @param CreateJobRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateJobRequest $request)
    {
        try{
            $this->service->create((new CreateJob($request)));
            return redirect()->route('jobs.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('jobs.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('job'));
    }

    /**
     * @param UpdateJobRequest $request
     * @param Job $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        try{
            $this->service->update((new UpdateJob($request)), $job);
            return redirect()->route('jobs.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('jobs.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return void
     */
    public function destroy(Job $job)
    {
        try{
            $job->delete();
            Session::flash('success','عملیات انجام شد');
        } catch (\Exception $exception) {
            Session::flash('error','عملیات با مشکل مواجه شد');
        }
    }
}
