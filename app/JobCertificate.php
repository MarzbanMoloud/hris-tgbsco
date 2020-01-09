<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class JobCertificate
 * @package App
 */
class JobCertificate extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    public const ENABLE = 1;
    public const DISABLE = 0;

    /**
     * statuses
     */
    public const STATUSES = [
        self::ENABLE => 'فعال',
        self::DISABLE => 'غیر فعال',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
