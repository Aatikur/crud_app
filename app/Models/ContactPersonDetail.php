<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPersonDetail extends Model
{
    use HasFactory;
    protected $table = 'contact_person_details';

    protected $fillable = ['mobile',
    'mail',
    'vendor_id'];
}
