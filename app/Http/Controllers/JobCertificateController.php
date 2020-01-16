<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreateJobCertificateRequest;
use App\Http\Requests\UpdateJobCertificateRequest;
use App\JobCertificate;
use App\Personnel;
use App\Services\JobCertificate\JobCertificateService;
use App\ValueObject\CreateJobCertificate;
use App\ValueObject\UpdateJobCertificate;
use Illuminate\Http\Request;


/**
 * Class JobCertificateController
 * @package App\Http\Controllers
 */
class JobCertificateController extends Controller
{
    /**
     * prefix of view
     */
    const PREFIX_VIEW = 'job-certificates.';

    /**
     * @var JobCertificateService
     */
    private $service;

    /**
     * JobCertificateController constructor.
     * @param JobCertificateService $service
     */
    public function __construct(JobCertificateService $service)
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
        $jobCertificates = $this->service->all(true);
        return view(self::PREFIX_VIEW . 'index', compact('jobCertificates'));
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
     * @param CreateJobCertificateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJobCertificateRequest $request)
    {
        try{
            $this->service->create((new CreateJobCertificate($request)));
            return redirect()->route('jobCertificates.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('jobCertificates.index')->with('error','عملیات با مشکل مواجه شد');
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
     * @param JobCertificate $jobCertificate
     * @return \Illuminate\Http\Response
     */
    public function edit(JobCertificate $jobCertificate)
    {
        return view(self::PREFIX_VIEW . 'edit', compact('jobCertificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateJobCertificateRequest $request
     * @param JobCertificate $jobCertificate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobCertificateRequest $request, JobCertificate $jobCertificate)
    {
        try{
            $this->service->update((new UpdateJobCertificate($request)), $jobCertificate);
            return redirect()->route('jobCertificates.index')->with('success','عملیات انجام شد');
        }catch(\Exception $e){
            return redirect()->route('jobCertificates.index')->with('error','عملیات با مشکل مواجه شد');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobCertificate $jobCertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobCertificate $jobCertificate)
    {
        try {
            $jobCertificate->delete();
            return redirect()->route('jobCertificates.index')->with('success', 'عملیات انجام شد');
        }catch (\Exception $e) {
            return redirect()->route('jobCertificates.index')->with('error', 'عملیات با مشکل مواجه شد');
        }
    }

    /**
     * @param Personnel $personnel
     * @return mixed
     */
    public function timesJobCertificateToDedicatedPersonnel(Personnel $personnel)
    {
        $times = $this->service->timesJobCertificateToDedicatedPersonnel($personnel->id);
        return $times;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $jobCertificates = $this->service->filterByPersonnel($request->personnelId);

        return view(self::PREFIX_VIEW . 'index', compact('jobCertificates'));
    }
}
