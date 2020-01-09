<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 9:53 AM
 */

namespace App\ValueObject;


use App\Help;
use App\Services\DateConverter\DateConverter;


/**
 * Class CreateHelp
 * @package App\ValueObject
 */
class CreateHelp
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
    public function getStatus()
    {
        return ($this->request->status == 'on') ? Help::ENABLE : Help::DISABLE;
    }
}