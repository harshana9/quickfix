<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\Status;

class Breakdown extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'mid',
        'merchant',
        'tid',
        'contact1',
        'contact2',
        'email',
        'error',
        'product'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product', 'id');
    }
}
