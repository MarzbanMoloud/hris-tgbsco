<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Event
 * @package App
 */
class Event extends Model
{
    use SoftDeletes;

    /**
     *
     */
    const STATUS = [
      0 => 'initiate',
      1 => 'canceled',
      2 => 'success'
    ];

    /**
     *
     */
    const SUCCESS = 2;

    /**
     *
     */
    const CANCELED = 1;

    /**
     *
     */
    const INITIATE = 0;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'caption',
        'alert_date',
        'created_by',
        'updated_by',
        'status'
    ];
}
