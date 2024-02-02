<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table= 'vendors';

    protected $fillable = ['vendor_name',
    'location_id',
    'address',
    'gst_details',
    'bank_details',
    'lane_name'];

    public function AgrementDetail()
    {
        return $this->hasMany('App\Models\AgreementDetail','vendor_id',$this->primaryKey);
    }

    public function ContactPersonDetail()
    {
        return $this->hasMany('App\Models\ContactPersonDetail','vendor_id',$this->primaryKey);
    }
}
