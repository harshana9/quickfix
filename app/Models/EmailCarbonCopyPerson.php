<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCarbonCopyPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'person',
        'email',
        'cc_level'
    ];
}
