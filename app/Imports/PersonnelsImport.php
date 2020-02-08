<?php


namespace App\Imports;


use App\Job;
use App\OrganizationalUnit;
use App\Personnel;
use App\Project;
use App\Services\DateConverter\DateConverter;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;


/**
 * Class PersonnelsImport
 * @package App\Imports
 */
class PersonnelsImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!Personnel::where('personnel_code', $row['kdprsnli'])->first()) {
                $personnel = Personnel::create([
                    'personnel_code' => $row['kdprsnli'],
                    'first_name' => $row['nam'],
                    'last_name' => $row['nam_khanoadgy'],
                    'father_name' => $row['nam_pdr'],
                    'certificate_id' => $row['shmarh_shnasnamh'] ?? null,
                    'issuance_location' => $row['sadrh'] ?? null,
                    'national_code' => $row['kd_mli'] ?? null,
                    'birth_date' => DateConverter::toTimestamp($row['tarikh_told']) ?? null,
                    'certificate_serial' => $row['shmarh_srial'] ?? null,
                    'children_count' => $row['taadad_frznd'] ?? null,
                    'issuance_id' => $row['shmarh_bimh'] ?? null,
                    'mobile_number' => $row['tlfn_hmrah'] ?? null,
                    'phone_number' => $row['tlfn_mnzl'] ?? null,
                    'address' => $row['aadrs'] ?? null,
                    'hire_date' => DateConverter::toTimestamp($row['tarykh_astkhdam']) ?? null,
                    'major' => $row['rshth_thsili'] ?? null,
                    'education_location' => $row['mhl_thsil'] ?? null,
                    'job_id' => Job::where('title', $row['shghl'])->first()->id ?? null,
                    'organizational_unit_id' => OrganizationalUnit::where('title', $row['oahdsazmani'])->first()->id ?? null,
                    'gender' => array_flip(Personnel::GENDER)[$row['jnsit']] ?? null,
                    'user_id' => auth()->id(),
                    'university_type' => array_flip(Personnel::UNIVERSITY_TYPES)[$row['noaa_danshgah']] ?? null,
                    'education_degree' => array_flip(Personnel::EDUCATION_DEGREE)[$row['sth_thsilat']] ?? null,
                    'military_status' => array_flip(Personnel::MILITARY_STATUS)[$row['odaait_ntham_othifh']] ?? null,
                    'marital_status' => array_flip(Personnel::MARITAL_STATUS)[$row['odaait_tahl']] ?? null,
                ]);

                if (isset($row['prozhh_ha'])){
                    $array = explode(',', $row['prozhh_ha']);

                    foreach ($array as $item){
                        if (isset(Project::where('title', trim($item))->first()->id)){
                            $ids[] = Project::where('title', trim($item))->first()->id;
                        }
                    }
                    if (! empty($ids)){
                        $personnel->projects()->sync($ids);
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
//            'personnel_code' => Rule::unique('personnels'),
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'personnel_code' => 'قبلا انتخاب شده است :attribute.',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return ['personnel_code' => 'کد پرسنلی'];
    }
}
