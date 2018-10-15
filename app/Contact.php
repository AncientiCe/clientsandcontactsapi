<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['address', 'post_code'];

    /**
     * Get the contacts record associated with the client.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
