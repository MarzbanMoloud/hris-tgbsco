<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 9:51 AM
 */

namespace App\Services\Help;


use App\Help;
use App\Services\DateConverter\DateConverter;
use App\ValueObject\CreateHelp;
use App\ValueObject\UpdateHelp;


/**
 * Class HelpService
 * @package App\Services\Help
 */
class HelpService
{
    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($paginate = false)
    {
        $helps = Help::query()
            ->has('personnel')
            ->orderBy('updated_at', 'DESC');
        if ($paginate){
            return $helps->paginate();
        }
        return $helps->get();
    }

    /**
     * @param CreateHelp $help
     * @return Help
     */
    public function create(CreateHelp $help): Help
    {
        return Help::create([
            'user_id' => auth()->id(),
            'personnel_id' => $help->getPersonnelId(),
            'amount' => $help->getAmount(),
            'receive_date' => $help->getReceiveDate(),
            //'status' => $help->getStatus(),
        ]);
    }

    /**
     * @param UpdateHelp $updateHelp
     * @param Help $help
     */
    public function update(UpdateHelp $updateHelp, Help $help)
    {
        $help->update([
            'user_id' => auth()->id(),
            'personnel_id' => $updateHelp->getPersonnelId(),
            'amount' => $updateHelp->getAmount(),
            'receive_date' => $updateHelp->getReceiveDate(),
            //'status' => $updateHelp->getStatus(),
        ]);
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function timesHelpToDedicatedPersonnel($personnelId)
    {
        $helps = Help::where('personnel_id', $personnelId)->get();

        $count = 0;

        if (! empty($helps)){

            $currentYear = DateConverter::getYearJalali(now()->timestamp);

            foreach ($helps as $key => $help){
                if (DateConverter::getYearJalali($help->receive_date) == $currentYear){
                    ++$count;
                }
            }

        }
        return $count;
    }

    public function filterByPersonnel($personnelId)
    {
        $helps = Help::query()
            ->has('personnel');
        if (! empty($personnelId)){
            $helps = $helps->where('personnel_id', $personnelId);
        }
        return $helps->orderBy('updated_at', 'DESC')
            ->paginate();
    }
}