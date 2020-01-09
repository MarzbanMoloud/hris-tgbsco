<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:12 PM
 */

namespace App\ValueObject;


/**
 * Class CreateOrganizationalUnit
 * @package App\ValueObject
 */
class CreateOrganizationalUnit
{
    /**
     * @var
     */
    private $request;

    /**
     * CreateOrganizationalUnit constructor.
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