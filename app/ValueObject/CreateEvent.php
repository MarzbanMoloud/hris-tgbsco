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
class CreateEvent
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
    public function getTitle()
    {
        return $this->request->title;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->request->caption;
    }

    /**
     * @return mixed
     */
    public function getAlertDate()
    {
        if (!is_null($this->request->alert_date)) {
            return DateConverter::toTimestamp($this->request->alert_date);
        }
        return null;
    }
}

