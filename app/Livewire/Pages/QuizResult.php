<?php

namespace App\Livewire\Pages;

use App\Models\GameResult;
use Livewire\Component;

class QuizResult extends Component
{
    public $result;

    public $game;

    public $userRank = 0;

    public $totalParticipants = 0;

    public $showCertificateModal = false;

    public function mount($result)
    {
        $this->result = GameResult::with(['game', 'user'])->findOrFail($result);
        $this->game = $this->result->game;

        // Calculate user rank
        $this->totalParticipants = GameResult::where('game_id', $this->game->id)->count();
        $this->userRank = GameResult::where('game_id', $this->game->id)
            ->where('total_points', '>', $this->result->total_points)
            ->count() + 1;
    }

    public function showCertificate()
    {
        $this->showCertificateModal = true;
    }

    public function closeCertificateModal()
    {
        $this->showCertificateModal = false;
    }

    public function downloadCertificate()
    {
        // Generate certificate ID if not exists
        $this->result->generateCertificateId();

        // This would integrate with a PDF generation service
        $this->dispatch('downloadCertificate', [
            'resultId' => $this->result->id,
            'certificateId' => $this->result->certificate_id,
        ]);
    }

    public function shareResult()
    {
        $shareText = $this->result->getSocialShareText();
        $shareUrl = $this->result->getShareUrl();

        $this->dispatch('shareResult', [
            'text' => $shareText,
            'url' => $shareUrl,
        ]);
    }

    public function playAgain()
    {
        if ($this->game->canUserPlay(auth()->id())) {
            return redirect()->route('quiz.start', ['game' => $this->game->id]);
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Cannot replay this game!',
            ]);
        }
    }

    public function backToQuizzes()
    {
        return redirect()->route('quiz');
    }

    public function viewProfile()
    {
        return redirect()->route('user.profile', ['activeTab' => 'history']);
    }

    public function getPerformanceGradeProperty()
    {
        return $this->result->getPerformanceGrade();
    }

    public function getPerformanceColorProperty()
    {
        return $this->result->getPerformanceColor();
    }

    public function getFormattedTimeTakenProperty()
    {
        return $this->result->getFormattedTimeTaken();
    }

    public function getSocialShareTextProperty()
    {
        return $this->result->getSocialShareText();
    }

    public function getQuestionBreakdownProperty()
    {
        return $this->result->question_details ?? [];
    }

    public function getPerformanceMetricsProperty()
    {
        return $this->result->performance_metrics ?? [];
    }

    public function getCanReplayProperty()
    {
        return $this->game->canUserPlay(auth()->id());
    }

    public function getReplayButtonTextProperty()
    {
        if (! $this->game->allow_replay) {
            return 'One-time Game';
        }

        if ($this->game->max_attempts) {
            $attempts = $this->game->gameResults()->where('user_id', auth()->id())->count();
            $remaining = $this->game->max_attempts - $attempts;

            return "Replay ({$remaining} attempts left)";
        }

        return 'Play Again';
    }

    public function getReplayButtonDisabledProperty()
    {
        return ! $this->canReplay;
    }

    public function render()
    {
        return view('livewire.pages.quiz-result')
            ->layout('components.layouts.app');
    }
}
