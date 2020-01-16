<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 3:30 PM
 */

namespace App\Services\Guarantee;


use App\Guarantee;
use App\Services\DateConverter\DateConverter;
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
            'delivery_date' => $guarantee->getDeliveryDate(),
            'type' => $guarantee->getType(),
            'use_case' => $guarantee->getUseCase(),
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
            'delivery_date' => $updateGuarantee->getDeliveryDate(),
            'type' => $updateGuarantee->getType(),
            'use_case' => $updateGuarantee->getUseCase(),
            //'status' => $updateGuarantee->getStatus(),
        ]);
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function timesGuaranteeToDedicatedPersonnel($personnelId)
    {
        $guarantees = Guarantee::where('personnel_id', $personnelId)->get();

        $count = 0;

        if (! empty($guarantees)){

            $currentYear = DateConverter::getYearJalali(now()->timestamp);

            foreach ($guarantees as $key => $guarantee){
                if (DateConverter::getYearJalali($guarantee->receive_date) == $currentYear){
                    ++$count;
                }
            }

        }
        return $count;
    }

    /**
     * @param $personnelId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filterByPersonnel($personnelId)
    {
        $guarantees = Guarantee::query()
            ->has('personnel');
        if (! empty($personnelId)){
            $guarantees = $guarantees->where('personnel_id', $personnelId);
        }
        return $guarantees->orderBy('updated_at', 'DESC')
            ->paginate();
    }
}