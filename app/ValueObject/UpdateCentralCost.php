<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:54 PM
 */

namespace App\ValueObject;


/**
 * Class UpdateCentralCost
 * @package App\ValueObject
 */
class UpdateCentralCost
{
    /**
     * @var
     */
    private $request;

    /**
     * UpdateJob constructor.
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