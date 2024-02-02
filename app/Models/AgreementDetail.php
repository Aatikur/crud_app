<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementDetail extends Model
{
    use HasFactory;

    protected $table = 'agreement_details';

    protected $fillable = ['file'
    ,'vendor_id'];
}
