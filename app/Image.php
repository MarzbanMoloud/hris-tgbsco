<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Image
 * @package App
 */
class Image extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'src',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function personnel()
    {
        return $this->hasOne(Personnel::Class);
    }
}
