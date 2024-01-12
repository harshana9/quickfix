<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Breakdown;
use App\Models\User;
use App\Models\Status;

class BreakdownStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'breakdown',
        'user',
        'status',
        'remark',
        'authorize'
    ];


    public function breakdown(): BelongsTo
    {
        return $this->belongsTo(Breakdown::class, 'breakdown', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }

    public function authorize(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorize', 'id');
    }
}
