<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:50 PM
 */

namespace App\ValueObject;


/**
 * Class CreateCentralCost
 * @package App\ValueObject
 */
class CreateCentralCost
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
}

