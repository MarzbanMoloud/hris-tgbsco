<?php


namespace App;


use Zizaco\Entrust\EntrustRole;


/**
 * Class Role
 * @package App
 */
class Role extends EntrustRole
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
