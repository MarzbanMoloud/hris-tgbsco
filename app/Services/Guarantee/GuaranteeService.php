<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 3:30 PM
 */

namespace App\Services\Guarantee;


use App\Guarantee;
use App\ValueObject\CreateGuarantee;
use App\ValueObject\UpdateGuarantee;


/**
 * Class GuaranteeService
 * @package App\Services\Guarantee
 */
class GuaranteeService
{
    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($paginate = false)
    {
        $guarantees = Guarantee::query()
            ->has('personnel')
            ->orderBy('updated_at', 'DESC');
        if ($paginate){
            return $guarantees->paginate();
        }
        return $guarantees->get();
    }

    /**
     * @param CreateGuarantee $guarantee
     * @return Guarantee
     */
    public function create(CreateGuarantee $guarantee): Guarantee
    {
        return Guarantee::create([
            'user_id' => auth()->id(),
            'personnel_id' => $guarantee->getPersonnelId(),
            'amount' => $guarantee->getAmount(),
            'receive_date' => $guarantee->getReceiveDate(),
            //'status' => $guarantee->getStatus(),
        ]);
    }

    /**
     * @param UpdateGuarantee $updateGuarantee
     * @param Guarantee $guarantee
     */
    public function update(UpdateGuarantee $updateGuarantee, Guarantee $guarantee)
    {
        $guarantee->update([
            'user_id' => auth()->id(),
            'personnel_id' => $updateGuarantee->getPersonnelId(),
            'amount' => $updateGuarantee->getAmount(),
            'receive_date' => $updateGuarantee->getReceiveDate(),
            //'status' => $updateGuarantee->getStatus(),
        ]);
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function timesGuaranteeToDedicatedPersonnel($personnelId)
    {
        return Guarantee::where('personnel_id', $personnelId)
            //->where('status', Guarantee::ENABLE)
            ->count();
    }
}