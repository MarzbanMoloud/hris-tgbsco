<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/6/2020
 * Time: 10:41 AM
 */

namespace App\Services\JobCertificate;


use App\JobCertificate;
use App\ValueObject\CreateJobCertificate;
use App\ValueObject\UpdateJobCertificate;


/**
 * Class JobCertificateService
 * @package App\Services\JobCertificate
 */
class JobCertificateService
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $jobCertificates = JobCertificate::query()
            ->has('personnel')
            ->orderBy('updated_at', 'DESC');
        if ($paginate){
            return $jobCertificates->paginate();
        }
        return $jobCertificates->get();
    }

    /**
     * @param CreateJobCertificate $jobCertificate
     * @return JobCertificate
     */
    public function create(CreateJobCertificate $jobCertificate) :JobCertificate
    {
        return JobCertificate::create([
            'user_id' => auth()->id(),
            'personnel_id' => $jobCertificate->getPersonnelId(),
            'receive_date' => $jobCertificate->getReceiveDate(),
            //'status' => $jobCertificate->getStatus(),
        ]);
    }

    /**
     * @param UpdateJobCertificate $updateJobCertificate
     * @param JobCertificate $jobCertificate
     */
    public function update(UpdateJobCertificate $updateJobCertificate, JobCertificate $jobCertificate)
    {
        $jobCertificate->update([
            'user_id' => auth()->id(),
            'personnel_id' => $updateJobCertificate->getPersonnelId(),
            'receive_date' => $updateJobCertificate->getReceiveDate(),
            //'status' => $updateJobCertificate->getStatus(),
        ]);
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function timesJobCertificateToDedicatedPersonnel($personnelId)
    {
        return JobCertificate::where('personnel_id', $personnelId)
            //->where('status', JobCertificate::ENABLE)
            ->count();
    }
}