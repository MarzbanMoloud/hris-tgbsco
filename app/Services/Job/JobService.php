<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:46 PM
 */

namespace App\Services\Job;


use App\Job;
use App\ValueObject\CreateJob;
use App\ValueObject\UpdateJob;
use Illuminate\Support\Facades\DB;


/**
 * Class JobService
 * @package App\Services\Job
 */
class JobService
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $jobs = Job::query();
        if ($paginate){
            return $jobs->paginate();
        }
        return $jobs->get();
    }

    /**
     * @param $title
     * @return mixed
     */
    public function findByTitle($title)
    {
        return Job::where('title', $title)->first();
    }

    /**
     * @param $jobId
     * @return mixed
     */
    public function findById($jobId)
    {
        return Job::where('id', $jobId)->first();
    }

    /**
     * @param CreateJob $job
     * @return Job
     */
    public function create(CreateJob $job) :Job
    {
        return Job::create([
            'title' => $job->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * @param UpdateJob $updateJob
     * @param Job $job
     */
    public function update(UpdateJob $updateJob, Job $job)
    {
        $job->update([
           'title' => $updateJob->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }
}