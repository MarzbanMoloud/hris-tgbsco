<?php


namespace App\Exports;


use App\Services\Personnel\PersonnelService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


/**
 * Class FilterPersonnelExport
 * @package App\Exports
 */
class FilterPersonnelExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
     * @var
     */
    private $request;
    private $filters;

    /**
     * FilterPersonnelExport constructor.
     * @param $request
     * @param $filters
     */
    public function __construct($request, $filters)
    {
        $this->request = $request;
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $filter = (new PersonnelService())->filter($this->request, false);

        return $this->transform($filter);
    }

    /**
     * @param $filter
     * @return array
     */
    public function transform($filter)
    {
        $data = array();
        foreach ($filter as $index => $personnel){
            foreach ($this->filters as $key => $item){
                $data[$index]['id'] = $personnel->id;
                switch ($item) {
                    case ('marital_status'):
                        $data[$index]['marital_status'] = (! is_null($personnel->marital_status)) ? \App\Personnel::MARITAL_STATUS[$personnel->marital_status] : '';
                        break;
                    case ('military_status'):
                        $data[$index]['military_status'] = (! is_null($personnel->military_status)) ? \App\Personnel::MILITARY_STATUS[$personnel->military_status] : '';
                        break;
                    case ('education_degree'):
                        $data[$index]['education_degree'] = (! is_null($personnel->education_degree)) ? \App\Personnel::EDUCATION_DEGREE[$personnel->education_degree] : '';
                        break;
                    case ('job_id'):
                        $data[$index]['job_id'] = $personnel->job->title ?? '';
                        break;
                    case ('central_cost_id'):
                        $data[$index]['central_cost_id'] = $personnel->centralCost->title ?? '';
                        break;
                    case ('organizational_unit_id'):
                        $data[$index]['organizational_unit_id'] = $personnel->organizationalUnit->title ?? '';
                        break;
                    case ('user_id'):
                        $data[$index]['user_id'] = \App\User::find($personnel->user_id)->name;
                        break;
                    case ('updated_at'):
                        $data[$index]['updated_at'] = (new \App\Services\DateConverter\DateConverter())::toJalali($personnel->updated_at);
                        break;
                    case ('birth_date'):
                        $data[$index]['birth_date'] = (! is_null($personnel->birth_date)) ? (new \App\Services\DateConverter\DateConverter())::toJalali($personnel->birth_date) : '';
                        break;
                    case ('gender'):
                        $data[$index]['gender'] = (! is_null($personnel->gender)) ? \App\Personnel::GENDER[$personnel->gender] : '';
                        break;
                    default:
                        $data[$index][$item] = $personnel->$item;
                }
            }
            if ($this->request->has('projects')){
                $temp = null;
                foreach($personnel->projects()->get() as $key => $project){
                    $temp = $temp . $project->title . ',';
                }
                $data[$index]['projects'] = $temp;
            }
        }
        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $filterHeading = array();
        foreach ($this->filters as $key => $item) {
            array_push($filterHeading, (new \App\Personnel())->filters[$item]);
        }
        if ($this->request->has('projects')) {
            array_push($filterHeading, 'پروژه');
        }

        return array_merge(['شناسه'], $filterHeading);
    }
}
