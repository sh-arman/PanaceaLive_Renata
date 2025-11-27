<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    //
    protected $table = 'check_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'code',
        'source',
        'remarks',
        'location'
    ];

    public function code()
    {
        return $this->belongsTo('App\Code');
    }
}
