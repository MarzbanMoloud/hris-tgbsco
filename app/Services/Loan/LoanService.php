<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/1/2020
 * Time: 8:41 AM
 */

namespace App\Services\Loan;


use App\Loan;
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
        $loans = Loan::query()->orderBy('updated_at', 'DESC');
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
            'status' => $loan->getStatus(),
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
            'status' => $updateLoan->getStatus(),
        ]);
    }

    /**
     * @param $personnelId
     * @return mixed
     */
    public function timesLoanToDedicatedPersonnel($personnelId)
    {
        return Loan::where('personnel_id', $personnelId)
            ->where('status', Loan::ENABLE)
            ->count();
    }
}