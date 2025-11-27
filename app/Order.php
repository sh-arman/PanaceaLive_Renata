<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'print_order';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'mfg_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

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
        return $this->hasMany(Code::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
