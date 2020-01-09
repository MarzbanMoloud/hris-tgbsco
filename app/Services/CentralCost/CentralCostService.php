<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 12/7/2019
 * Time: 10:32 AM
 */

namespace App\Services\CentralCost;


use App\CentralCost;
use App\ValueObject\CreateCentralCost;
use App\ValueObject\UpdateCentralCost;


/**
 * Class CentralCostService
 * @package App\Services\CentralCost
 */
class CentralCostService
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $jobs = CentralCost::latest();
        if ($paginate){
            return $jobs->paginate();
        }
        return $jobs->get();
    }

    /**
     * @param $title
     * @return mixed
     */
    public function findByTitle($title)
    {
        return CentralCost::where('title', $title)->first();
    }

    /**
     * @param $centralCostId
     * @return mixed
     */
    public function findById($centralCostId)
    {
        return CentralCost::where('id', $centralCostId)->first();
    }

    public function create(CreateCentralCost $centralCost) :CentralCost
    {
        return CentralCost::create([
            'title' => $centralCost->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }

    public function update(UpdateCentralCost $updateCentralCost, CentralCost $centralCost)
    {
        $centralCost->update([
            'title' => $updateCentralCost->getTitle(),
            'user_id' => auth()->id(),
        ]);
    }
}