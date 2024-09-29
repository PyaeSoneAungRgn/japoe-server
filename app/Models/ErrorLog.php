<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'exception',
        'message',
        'group',
        'host',
        'method',
        'path',
        'headers',
        'query',
        'body',
        'controller',
        'command',
        'timezone',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'headers' => 'array',
        'query' => 'array',
        'body' => 'array',
        'command' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function errorLogFrames(): HasMany
    {
        return $this->hasMany(ErrorLogFrame::class);
    }

    public function firstErrorLogFrame(): HasOne
    {
        return $this->hasOne(ErrorLogFrame::class);
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(ErrorLog::class, 'group', 'group');
    }

    public function firstOccurrence(): HasOne
    {
        return $this->hasOne(ErrorLog::class, 'group', 'group')->orderBy('created_at');
    }

    public function lastOccurrence(): HasOne
    {
        return $this->hasOne(ErrorLog::class, 'group', 'group')->orderByDesc('created_at');
    }

    public function errorGroup(): HasOne
    {
        return $this->hasOne(ErrorGroup::class, 'group', 'group');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->setTimezone($this->timezone),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->setTimezone($this->timezone),
        );
    }
}
