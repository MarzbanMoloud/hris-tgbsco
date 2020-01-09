<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Personnel
 * @package App
 */
class Personnel extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    public $filters = [
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'father_name' => 'نام پدر',
        'certificate_id' => 'شماره شناسنامه',
        'national_code' => 'کدملی',
        'birth_date' => 'تاریخ تولد',
        'certificate_serial' => 'شماره سریال',
        'issuance_location' => 'محل صدور',
        'marital_status' => 'وضعیت تاهل',
        'issuance_id' => 'شماره بیمه',
        'military_status' => 'وضعیت نظام وظیفه',
        'education_degree' => 'مدرک تحصیلی',
        'major' => 'رشته تحصیلی',
        'education_location' => 'محل تحصیل',
        'central_cost_id' => 'مرکز هزینه',
        'job_id' => 'شغل',
        'user_id' => 'کاربر',
        'updated_at' => 'اخرین ویرایش',
        'organizational_unit_id' => 'واحد سازمانی',
        'gender' => 'جنسیت',
    ];

    /**
     *
     */
    const MARITAL_STATUS = [
        0 => 'مجرد',
        1 => 'متاهل',
    ];

    const SINGLE = 0;
    const MARRIED = 1;

    const GENDER = [
        self::FEMALE => 'زن',
        self::MALE => 'مرد',
    ];

    const FEMALE = 0;
    const MALE = 1;

    /**
     *
     */
    const MILITARY_STATUS = [
        0 => 'معافیت دایم',
        1 => 'معافیت تحصیلی',
        2 => 'مشمول',
        3 => 'در حال انجام',
        4 => 'پایان خدمت',
        5 => 'نامشخص',
    ];

    /**
     *
     */
    const EDUCATION_DEGREE = [
        0 => 'زیردیپلم',
        1 => 'دیپلم',
        2 => 'کاردانی',
        3 => 'کارشناسی',
        4 => 'کارشناسی ارشد',
        5 => 'دکتری',
    ];

    /**
     *
     */
    const UNIVERSITY_TYPES = [
        0 => 'آزاد',
        1 => 'سراسری',
        2 => 'غیرانتفاعی',
        3 => 'پیام نور',
        4 => 'علمی کاربردی',
        5 => 'مجازی',
        6 => 'موارد دیکر',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function centralCost()
    {
        return $this->belongsTo(CentralCost::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helps()
    {
        return $this->hasMany(Help::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guarantees()
    {
        return $this->hasMany(Guarantee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobCertificates()
    {
        return $this->hasMany(JobCertificate::class);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
