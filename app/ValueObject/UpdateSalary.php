<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/7/2020
 * Time: 4:44 PM
 */

namespace App\ValueObject;


/**
 * Class UpdateSalary
 * @package App\ValueObject
 */
class UpdateSalary
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
        return $this->request->personnel_id;
    }

    /**
     * @return mixed
     */
    public function getInsuranceAmount()
    {
        $amount = trim(str_replace(array(' ', 'ریال', ','), '', $this->request->insurance_amount));
        return $amount;
    }

    /**
     * @return mixed
     */
    public function getBenefitOfAmount()
    {
        $amount = trim(str_replace(array(' ', 'ریال', ','), '', $this->request->benefit_of_amount));
        return $amount;
    }
}