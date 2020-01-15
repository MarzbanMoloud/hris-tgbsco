<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Salary
 * @package App
 */
class Salary extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
