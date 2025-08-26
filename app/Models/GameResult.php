<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GameResult extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'game_id',
        'score',
        'total_questions',
        'answers',
        'total_points',
        'max_possible_points',
        'correct_answers',
        'incorrect_answers',
        'time_taken',
        'accuracy_percentage',
        'attempt_number',
        'certificate_id',
        'certificate_generated_at',
        'question_details',
        'performance_metrics',
        'device_info',
        'ip_address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'answers' => 'array',
        'question_details' => 'array',
        'performance_metrics' => 'array',
        'certificate_generated_at' => 'datetime',
        'accuracy_percentage' => 'decimal:2',
    ];

    /**
     * Get the user that owns the result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game that owns the result.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Generate a unique certificate ID.
     */
    public function generateCertificateId(): string
    {
        if (! $this->certificate_id) {
            $this->certificate_id = 'CERT-'.strtoupper(Str::random(8)).'-'.$this->id;
            $this->certificate_generated_at = now();
            $this->save();
        }

        return $this->certificate_id;
    }

    /**
     * Check if certificate has been generated.
     */
    public function hasCertificate(): bool
    {
        return ! is_null($this->certificate_id);
    }

    /**
     * Get certificate download URL.
     */
    public function getCertificateUrl(): string
    {
        return route('certificate.download', ['result' => $this->id]);
    }

    /**
     * Get certificate share URL.
     */
    public function getShareUrl(): string
    {
        return route('certificate.share', ['result' => $this->id]);
    }

    /**
     * Get performance grade based on accuracy.
     */
    public function getPerformanceGrade(): string
    {
        $percentage = $this->accuracy_percentage;

        if ($percentage >= 90) {
            return 'A+';
        }
        if ($percentage >= 80) {
            return 'A';
        }
        if ($percentage >= 70) {
            return 'B+';
        }
        if ($percentage >= 60) {
            return 'B';
        }
        if ($percentage >= 50) {
            return 'C+';
        }
        if ($percentage >= 40) {
            return 'C';
        }
        if ($percentage >= 30) {
            return 'D';
        }

        return 'F';
    }

    /**
     * Get performance color based on accuracy.
     */
    public function getPerformanceColor(): string
    {
        $percentage = $this->accuracy_percentage;

        if ($percentage >= 80) {
            return 'green';
        }
        if ($percentage >= 60) {
            return 'yellow';
        }
        if ($percentage >= 40) {
            return 'orange';
        }

        return 'red';
    }

    /**
     * Get formatted time taken.
     */
    public function getFormattedTimeTaken(): string
    {
        if (! $this->time_taken) {
            return 'N/A';
        }

        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }

        return "{$seconds}s";
    }

    /**
     * Get social media share text.
     */
    public function getSocialShareText(): string
    {
        $grade = $this->getPerformanceGrade();
        $percentage = $this->accuracy_percentage;

        return "I scored {$this->score}/{$this->total_questions} ({$percentage}%) with grade {$grade} on {$this->game->name}! 🏆 #UseSwadeshi #SwadeshiAbhiyan #VocalForLocal";
    }

    /**
     * Scope to get user's results.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get game results.
     */
    public function scopeForGame($query, $gameId)
    {
        return $query->where('game_id', $gameId);
    }

    /**
     * Scope to get recent results.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope to get best results.
     */
    public function scopeBest($query)
    {
        return $query->orderBy('total_points', 'desc')
            ->orderBy('accuracy_percentage', 'desc');
    }
}
