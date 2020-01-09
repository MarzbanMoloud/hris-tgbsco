<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 12/8/2019
 * Time: 11:38 AM
 */


namespace App\ValueObject;


use App\Services\DateConverter\DateConverter;

class UpdateEvent
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