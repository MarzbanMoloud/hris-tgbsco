<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Loan
 * @package App
 */
class Loan extends Model
{
    use SoftDeletes;

    public const ENABLE = 1;
    public const DISABLE = 0;

    /**
     * statuses
     */
    public const STATUSES = [
        self::ENABLE => 'فعال',
        self::DISABLE => 'غیر فعال',
    ];

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
