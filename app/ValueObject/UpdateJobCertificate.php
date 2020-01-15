<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/6/2020
 * Time: 10:51 AM
 */

namespace App\ValueObject;


use App\JobCertificate;
use App\Services\DateConverter\DateConverter;


/**
 * Class UpdateJobCertificate
 * @package App\ValueObject
 */
class UpdateJobCertificate
{
    /**
     * @var
     */
    private $request;

    /**
     * CreateLoan constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getPersonnelId()
    {
        return $this->request->personnelId;
    }

    /**
     * @return mixed
     */
    public function getReceiveDate()
    {
        if (!is_null($this->request->receive_date)) {
            return DateConverter::toTimestamp($this->request->receive_date);
        }
        return null;
    }

//    /**
//     * @return mixed
//     */
//    public function getStatus()
//    {
//        return ($this->request->status == 'on') ? JobCertificate::ENABLE : JobCertificate::DISABLE;
//    }
}