<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\GameResult;
use Livewire\Component;
use Livewire\WithPagination;

class UserProfile extends Component
{
    use WithPagination;

    public $user;

    public $activeTab = 'profile';

    public $showCertificateModal = false;

    public $selectedResult = null;

    public $editMode = false;

    public $userData = [];

    // Profile fields
    public $name;

    public $email;

    public $phone;

    public $city;

    public $state;

    public $country;

    protected $queryString = ['activeTab'];

    public function mount()
    {
        $this->user = auth()->user();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone ?? '';
        $this->city = $this->user->city ?? '';
        $this->state = $this->user->state ?? '';
        $this->country = $this->user->country ?? '';
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function toggleEditMode()
    {
        $this->editMode = ! $this->editMode;
        if (! $this->editMode) {
            $this->loadUserData(); // Reset to original values
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        $this->editMode = false;
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('messages.profile_updated'),
        ]);
    }

    public function showCertificate($resultId)
    {
        $this->selectedResult = GameResult::with(['game', 'user'])->find($resultId);
        $this->showCertificateModal = true;
    }

    public function closeCertificateModal()
    {
        $this->showCertificateModal = false;
        $this->selectedResult = null;
    }

    public function downloadCertificate($resultId)
    {
        $result = GameResult::with(['game', 'user'])->find($resultId);

        if (! $result) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('messages.result_not_found'),
            ]);

            return;
        }

        // Generate certificate ID if not exists
        $result->generateCertificateId();

        // This would integrate with a PDF generation service
        $this->dispatch('downloadCertificate', [
            'resultId' => $result->id,
            'certificateId' => $result->certificate_id,
        ]);
    }

    public function shareResult($resultId)
    {
        $result = GameResult::with(['game'])->find($resultId);

        if (! $result) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('messages.result_not_found'),
            ]);

            return;
        }

        $shareText = $result->getSocialShareText();
        $shareUrl = $result->getShareUrl();

        $this->dispatch('shareResult', [
            'text' => $shareText,
            'url' => $shareUrl,
        ]);
    }

    public function replayGame($gameId)
    {
        $game = Game::find($gameId);

        if (! $game || ! $game->canUserPlay($this->user->id)) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('messages.cannot_replay_game'),
            ]);

            return;
        }

        return redirect()->route('quiz.start', ['game' => $game->id]);
    }

    public function getUserResultsProperty()
    {
        return GameResult::with(['game'])
            ->where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getUserStatsProperty()
    {
        $results = GameResult::where('user_id', $this->user->id);

        return [
            'total_attempts' => $results->count(),
            'total_games_played' => $results->distinct('game_id')->count(),
            'best_score' => $results->max('score'),
            'average_accuracy' => round($results->avg('accuracy_percentage'), 1),
            'total_points_earned' => $results->sum('total_points'),
            'certificates_earned' => $results->whereNotNull('certificate_id')->count(),
        ];
    }

    public function getGameResultsProperty()
    {
        return Game::with(['gameResults' => function ($query) {
            $query->where('user_id', $this->user->id)
                ->orderBy('created_at', 'desc');
        }])
            ->whereHas('gameResults', function ($query) {
                $query->where('user_id', $this->user->id);
            })
            ->get();
    }

    public function getRecentActivityProperty()
    {
        return GameResult::with(['game'])
            ->where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.user-profile');
    }
}
