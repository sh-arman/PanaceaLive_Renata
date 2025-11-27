<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    protected $table = 'medicine';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'medicine_name',
        'medicine_scientific_name',
        'medicine_type',
        'medicine_dosage',
        'dar_license_number',
        'mfg_license_number',
        'status',
        'created_by',
        'updated_by',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function codes()
    {
        return $this->hasMany('App\Code');
    }
}
