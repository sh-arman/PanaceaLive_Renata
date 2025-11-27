<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'print_order';

    protected $dates = ['mfg_date', 'expiry_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'medicine_id',
        'mfg_date',
        'expiry_date',
        'batch_number',
        'quantity',
        'file',
        'destination',
        'status',
        'created_by',
        'updated_by',
        'schedule',
    ];

    public function codes()
    {
        return $this->hasMany('App\Code');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function medicine()
    {
        return $this->belongsTo('App\Medicine');
    }
}
