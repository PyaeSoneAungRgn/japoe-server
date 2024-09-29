<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLogFrame extends Model
{
    use HasFactory;

    protected $fillable = [
        'error_log_id',
        'snippet',
        'line_number',
        'file',
        'method',
    ];

    protected $casts = [
        'snippet' => 'array',
    ];

    public function getFirstLine(): ?int
    {
        return array_key_first($this->snippet);
    }

    public function getSnippet(): string
    {
        return collect($this->snippet)->map(function ($line, $number) {
            if ($number == $this->line_number) {
                return '{-'.$line.'-}';
            }

            return $line;
        })
            ->join(PHP_EOL);
    }
}
