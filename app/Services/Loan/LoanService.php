<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 8:41 AM
 */

namespace App\Services\Loan;


use App\Loan;
use App\Services\DateConverter\DateConverter;
use App\ValueObject\CreateLoan;
use App\ValueObject\UpdateLoan;


/**
 * Class LoanService
 * @package App\Services\Loan
 */
class LoanService
{
    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($paginate = false)
    {
        $loans = Loan::query()
            ->has('personnel')
            ->orderBy('updated_at', 'DESC');
        if ($paginate){
            return $loans->paginate();
        }
        return $loans->get();
    }

    /**
     * @param CreateLoan $loan
     * @return Loan
     */
    public function create(CreateLoan $loan): Loan
    {
        return Loan::create([
            'user_id' => auth()->id(),
            'personnel_id' => $loan->getPersonnelId(),
            'amount' => $loan->getAmount(),
            'receive_date' => $loan->getReceiveDate(),
            'settlement_date' => $loan->getSettlementDate(),
            //'status' => $loan->getStatus(),
        ]);
    }

    /**
     * @param UpdateLoan $updateLoan
     * @param Loan $loan
     */
    public function update(UpdateLoan $updateLoan, Loan $loan)
    {
        $loan->update([
            'user_id' => auth()->id(),
            'personnel_id' => $updateLoan->getPersonnelId(),
            'amount' => $updateLoan->getAmount(),
            'receive_date' => $updateLoan->getReceiveDate(),
            'settlement_date' => $updateLoan->getSettlementDate(),
            //'status' => $updateLoan->getStatus(),
        ]);
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function timesLoanToDedicatedPersonnel($personnelId)
    {
        $loans = Loan::where('personnel_id', $personnelId)->get();

        $count = 0;

        if (! empty($loans)){

            $currentYear = DateConverter::getYearJalali(now()->timestamp);

            foreach ($loans as $key => $loan){
                if (DateConverter::getYearJalali($loan->receive_date) == $currentYear){
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
        $loans = Loan::query()
            ->has('personnel');
        if (! empty($personnelId)){
            $loans = $loans->where('personnel_id', $personnelId);
        }
        return $loans->orderBy('updated_at', 'DESC')
            ->paginate();
    }
}