<?php


namespace App\Services\Personnel;


use App\Personnel;
use App\ValueObject\CreatePersonnel;
use App\ValueObject\UpdatePersonnel;


/**
 * Class PersonnelService
 * @package App\Services\Personnel
 */
class PersonnelService
{
    const BASIC_FILTERS = ['id', 'first_name', 'last_name', 'user_id', 'updated_at'];
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $personnels = Personnel::latest();

        if ($paginate){
            return $personnels->paginate();
        }

        return $personnels->get();
    }

    /**
     * @param $request
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function filter($request, $paginate = false)
    {
        $personnels = Personnel::query();

        if (isset($request->projects)){
            $personnels->whereHas('projects', function ($q) use ($request){
                $q->whereIn('projects.id', $request->projects);
            });
        }

        if (isset($request->organizationalUnit)){
            $personnels->where('organizational_unit_id', $request->organizationalUnit);
        }

        //if (isset($request->centralCost)){
           // $personnels->where('central_cost_id', $request->centralCost);
        //}

        if (isset($request->job)){
            $personnels->where('job_id', $request->job);
        }

        if (isset($request->sort)){
            $personnels->orderBy('updated_at', $request->sort);
        }

        if (isset($request->personnelStatus)){
            if ($request->personnelStatus == 1)
                $personnels->where('end_date', '=' , null);
            elseif($request->personnelStatus == 0)
                $personnels->where('end_date', '<>' ,null);
            elseif($request->personnelStatus == 2)
                $personnels->onlyTrashed();
        }

        if (isset($request->filter)){
            $data = array_merge(['id'], $request->filter);
        }else{
            $data = self::BASIC_FILTERS;
        }
        $personnels->select($data);

        if ($paginate){
            return $personnels->paginate();
        }

        return $personnels->get();
    }

    /**
     * @param $personnelCode
     * @return mixed
     */
    public function findByPersonnelCode($personnelCode)
    {
        return Personnel::where('personnel_code', $personnelCode)->first();
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function findByPersonnelId($personnelId)
    {
        return Personnel::where('id', $personnelId)->first();
    }

    /**
     * @param CreatePersonnel $createPersonnel
     * @return Personnel
     */
    public function create(CreatePersonnel $createPersonnel) :Personnel
    {
        $personnel = Personnel::create([
            'first_name' => $createPersonnel->getFirstName(),
            'last_name' => $createPersonnel->getLastName(),
            'father_name' => $createPersonnel->getFatherName(),
            'certificate_id' => $createPersonnel->getCertificateId(),
            'national_code' => $createPersonnel->getNationalCode(),
            'birth_date' => $createPersonnel->getBirthDate(),
            'certificate_serial' => $createPersonnel->getCertificateSerial(),
            'issuance_location' => $createPersonnel->getIssuanceLocation(),
            'marital_status' => $createPersonnel->getMaritalStatus(),
            'children_count' => ($createPersonnel->getMaritalStatus() == Personnel::MARRIED) ? $createPersonnel->getChildrenCount() : null,
            'issuance_id' => $createPersonnel->getIssuanceId(),
            'military_status' => ( $createPersonnel->getGender() == Personnel::MALE )? $createPersonnel->getMilitaryStatus() : null,
            'education_degree' => $createPersonnel->getEducationDegree(),
            'major' => $createPersonnel->getMajor(),
            'education_location' => $createPersonnel->getEducationLocation(),
            'university_type' => $createPersonnel->getUniversityType(),
            'personnel_code' => $createPersonnel->getPersonnelCode(),
            'hire_date' => $createPersonnel->getHireDate(),
            'end_date' => $createPersonnel->getEndDate(),
            'organizational_unit_id' => $createPersonnel->getOrganizationalUnitId(),
            'image_id' => $createPersonnel->getImageId(),
            'job_id' => $createPersonnel->getJobId(),
            'central_cost_id' => $createPersonnel->getCentralCostId(),
            'mobile_number' => $createPersonnel->getMobileNumber(),
            'phone_number' => $createPersonnel->getPhoneNumber(),
            'address' => $createPersonnel->getAddress(),
            'user_id' => auth()->id(),
            'gender' => $createPersonnel->getGender(),
        ]);

        $personnel->projects()->sync( $createPersonnel->getProjects() );
        return $personnel;
    }

    /**
     * @param UpdatePersonnel $updatePersonnel
     * @param Personnel $personnel
     */
    public function update(UpdatePersonnel $updatePersonnel, Personnel $personnel)
    {
        $personnel->update([
            'first_name' => $updatePersonnel->getFirstName(),
            'last_name' => $updatePersonnel->getLastName(),
            'father_name' => $updatePersonnel->getFatherName(),
            'certificate_id' => $updatePersonnel->getCertificateId(),
            'national_code' => $updatePersonnel->getNationalCode(),
            'birth_date' => $updatePersonnel->getBirthDate(),
            'certificate_serial' => $updatePersonnel->getCertificateSerial(),
            'issuance_location' => $updatePersonnel->getIssuanceLocation(),
            'marital_status' => $updatePersonnel->getMaritalStatus(),
            'children_count' => ($updatePersonnel->getMaritalStatus() == Personnel::MARRIED) ? $updatePersonnel->getChildrenCount() : null,
            'issuance_id' => $updatePersonnel->getIssuanceId(),
            'military_status' => ( $updatePersonnel->getGender() == Personnel::MALE )? $updatePersonnel->getMilitaryStatus() : null,
            'education_degree' => $updatePersonnel->getEducationDegree(),
            'major' => $updatePersonnel->getMajor(),
            'education_location' => $updatePersonnel->getEducationLocation(),
            'university_type' => $updatePersonnel->getUniversityType(),
            'personnel_code' => $updatePersonnel->getPersonnelCode(),
            'hire_date' => $updatePersonnel->getHireDate(),
            'end_date' => $updatePersonnel->getEndDate(),
            'organizational_unit_id' => $updatePersonnel->getOrganizationalUnitId(),
            'image_id' => $updatePersonnel->getImageId(),
            'job_id' => $updatePersonnel->getJobId(),
            'central_cost_id' => $updatePersonnel->getCentralCostId(),
            'mobile_number' => $updatePersonnel->getMobileNumber(),
            'phone_number' => $updatePersonnel->getPhoneNumber(),
            'address' => $updatePersonnel->getAddress(),
            'user_id' => auth()->id(),
            'gender' => $updatePersonnel->getGender(),
        ]);
        $personnel->projects()->sync( $updatePersonnel->getProjects() );
    }
}