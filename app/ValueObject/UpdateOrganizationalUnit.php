<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:18 PM
 */

namespace App\ValueObject;


/**
 * Class UpdateOrganizationalUnit
 * @package App\ValueObject
 */
/**
 * Class UpdateOrganizationalUnit
 * @package App\ValueObject
 */
class UpdateOrganizationalUnit
{
    /**
     * @var
     */
    private $request;

    /**
     * UpdateOrganizationalUnit constructor.
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