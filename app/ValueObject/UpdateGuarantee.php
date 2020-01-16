<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 3:31 PM
 */

namespace App\ValueObject;


use App\Guarantee;
use App\Services\DateConverter\DateConverter;


/**
 * Class UpdateGuarantee
 * @package App\ValueObject
 */
class UpdateGuarantee
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
    public function getAmount()
    {
        $amount = trim(str_replace(array(' ', 'ریال', ','), '', $this->request->amount));
        return $amount;
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

    /**
     * @return mixed
     */
    public function getDeliveryDate()
    {
        if (!is_null($this->request->delivery_date)) {
            return DateConverter::toTimestamp($this->request->delivery_date);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->request->type;
    }

    /**
     * @return mixed
     */
    public function getUseCase()
    {
        return $this->request->use_case;
    }

//    /**
//     * @return mixed
//     */
//    public function getStatus()
//    {
//        return ($this->request->status == 'on') ? Guarantee::ENABLE : Guarantee::DISABLE;
//    }
}