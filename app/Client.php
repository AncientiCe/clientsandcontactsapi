<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['first_name', 'email'];

    /**
     * Get the contacts record associated with the client.
     */
    public function contact()
    {
        return $this->hasMany('App\Contact');
    }
}
