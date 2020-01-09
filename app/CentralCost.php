<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


/**
 * Class CentralCost
 * @package App
 */
class CentralCost extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function personnel()
    {
        return $this->hasOne(Personnel::Class);
    }
}
