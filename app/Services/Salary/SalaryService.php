<?php
/**
 * Created by PhpStorm.
 * User: m.marzban
 * Date: 1/7/2020
 * Time: 3:49 PM
 */

namespace App\Services\Salary;


use App\Personnel;
use App\Salary;
use App\ValueObject\CreateSalary;


/**
 * Class SalaryService
 * @package App\Services\Salary
 */
class SalaryService
{
    /**
     *
     */
    const BASIC_FILTERS = ['id', 'first_name', 'last_name', 'user_id', 'updated_at'];

    /**
     * @param bool $paginate
     * @return mixed
     */
    public function all($paginate = false)
    {
        $personnels = Personnel::latest();

        if ($paginate){
            return $personnels->paginate();
        }

        return $personnels->get();
    }

    /**
     * @param CreateSalary $salary
     * @return mixed
     */
    public function create(CreateSalary $salary)
    {
        $salaryRecord = Salary::where('personnel_id', $salary->getPersonnelId())->first();
        if (empty($salaryRecord)){
            return Salary::create([
                'user_id' => auth()->id(),
                'personnel_id' => $salary->getPersonnelId(),
                'insurance_amount' => $salary->getInsuranceAmount(),
                'benefit_of_amount' => $salary->getBenefitOfAmount(),
            ]);
        }

        return $salaryRecord->update([
            'user_id' => auth()->id(),
            'insurance_amount' => $salary->getInsuranceAmount(),
            'benefit_of_amount' => $salary->getBenefitOfAmount(),
        ]);
    }

    /**
     * @param $request
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function filter($request, $paginate = false)
    {
        $personnels = Personnel::query();

        if (isset($request->projects)){
            $personnels->whereHas('projects', function ($q) use ($request){
                $q->whereIn('projects.id', $request->projects);
            });
        }

        if (isset($request->organizationalUnit)){
            $personnels->where('organizational_unit_id', $request->organizationalUnit);
        }

        //if (isset($request->centralCost)){
        // $personnels->where('central_cost_id', $request->centralCost);
        //}

        if (isset($request->job)){
            $personnels->where('job_id', $request->job);
        }

        if (isset($request->sort)){
            $personnels->orderBy('updated_at', $request->sort);
        }

        if (isset($request->personnelStatus)){
            if ($request->personnelStatus == 1)
                $personnels->where('end_date', '=' , null);
            elseif($request->personnelStatus == 0)
                $personnels->where('end_date', '<>' ,null);
            elseif($request->personnelStatus == 2)
                $personnels->onlyTrashed();
        }

        if (isset($request->filter)){
            $data = array_merge(['id'], $request->filter);
        }else{
            $data = self::BASIC_FILTERS;
        }
        $personnels->select($data);

        if ($paginate){
            return $personnels->paginate();
        }

        return $personnels->get();
    }

}