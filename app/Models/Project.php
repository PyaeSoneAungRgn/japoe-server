<?php

namespace App\Models;

use App\Enums\ProjectEnvironmentEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'environment',
        'key',
        'team_id',
    ];

    protected $casts = [
        'environment' => ProjectEnvironmentEnum::class,
    ];

    public function lastErrorLog(): HasOne
    {
        return $this->hasOne(ErrorLog::class);
    }

    public function errorLogs(): HasMany
    {
        return $this->hasMany(ErrorLog::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
