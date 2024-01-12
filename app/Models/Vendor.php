<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'main_email',
        'cc_email_1',
        'cc_email_2',
        'cc_email_3',
        'contact_1',
        'contact_2',
        'address'
    ];
}
