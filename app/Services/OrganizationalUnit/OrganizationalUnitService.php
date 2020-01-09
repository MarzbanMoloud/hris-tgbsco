<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 8/31/2019
 * Time: 7:07 PM
 */

namespace App\Services\OrganizationalUnit;


use App\OrganizationalUnit;
use App\ValueObject\CreateOrganizationalUnit;
use App\ValueObject\UpdateOrganizationalUnit;


/**
 * Class OrganizationalUnitService
 * @package App\Services\OrganizationalUnit
 */
class OrganizationalUnitService
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        if ($paginate){
            return OrganizationalUnit::paginate();
        }
        return OrganizationalUnit::get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return OrganizationalUnit::find($id);
    }

    /**
     * @param $title
     * @return mixed
     */
    public function findByTitle($title)
    {
        return OrganizationalUnit::where('title', $title)->first();
    }

    /**
     * @param CreateOrganizationalUnit $organizationalUnit
     * @return mixed
     */
    public function create(CreateOrganizationalUnit $organizationalUnit)
    {
        return OrganizationalUnit::create([
            'title' => $organizationalUnit->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * @param UpdateOrganizationalUnit $updateOrganizationalUnit
     * @param $organizationalUnit
     * @return mixed
     */
    public function update(UpdateOrganizationalUnit $updateOrganizationalUnit, OrganizationalUnit $organizationalUnit)
    {
        $organizationalUnit->update([
            'title' => $updateOrganizationalUnit->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }
}