<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:50 PM
 */


namespace App\ValueObject;


use App\Services\DateConverter\DateConverter;

/**
 * Class CreateJob
 * @package App\ValueObject
 */
class CreatePersonnel
{
    /**
     * @var
     */
    private $request;

    /**
     * CreateJob constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->request->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->request->last_name;
    }

    /**
     * @return mixed
     */
    public function getFatherName()
    {
        return $this->request->father_name;
    }

    /**
     * @return mixed
     */
    public function getCertificateId()
    {
        return $this->request->certificate_id;
    }

    /**
     * @return mixed
     */
    public function getNationalCode()
    {
        return $this->request->national_code;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        if (!is_null($this->request->birth_date)) {
            return DateConverter::toTimestamp($this->request->birth_date);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getCertificateSerial()
    {
        return $this->request->certificate_serial;
    }

    /**
     * @return mixed
     */
    public function getIssuanceLocation()
    {
        return $this->request->issuance_location;
    }

    /**
     * @return mixed
     */
    public function getMaritalStatus()
    {
        return $this->request->marital_status;
    }

    /**
     * @return mixed
     */
    public function getChildrenCount()
    {
        return $this->request->children_count;
    }

    /**
     * @return mixed
     */
    public function getIssuanceId()
    {
        return $this->request->issuance_id;
    }

    /**
     * @return mixed
     */
    public function getMilitaryStatus()
    {
        return $this->request->military_status;
    }

    /**
     * @return mixed
     */
    public function getEducationDegree()
    {
        return $this->request->education_degree;
    }

    /**
     * @return mixed
     */
    public function getMajor()
    {
        return $this->request->major;
    }

    /**
     * @return mixed
     */
    public function getEducationLocation()
    {
        return $this->request->education_location;
    }

    /**
     * @return mixed
     */
    public function getUniversityType()
    {
        return $this->request->university_type;
    }

    /**
     * @return mixed
     */
    public function getPersonnelCode()
    {
        return $this->request->personnel_code;
    }

    /**
     * @return mixed
     */
    public function getHireDate()
    {
        if (!is_null($this->request->hire_date)){
            return DateConverter::toTimestamp($this->request->hire_date);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        if (!is_null($this->request->end_date)) {
            return DateConverter::toTimestamp($this->request->end_date);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getOrganizationalUnitId()
    {
        return $this->request->organizational_unit_id;
    }

    /**
     * @return mixed
     */
    public function getImageId()
    {
        return $this->request->image_id;
    }

    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->request->job_id;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->request->projects;
    }

    /**
     * @return mixed
     */
    public function getCentralCostId()
    {
        return $this->request->central_cost_id;
    }

    /**
     * @return mixed
     */
    public function getMobileNumber()
    {
        return $this->request->mobile_number;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->request->phone_number;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->request->address;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->request->gender;
    }
}

