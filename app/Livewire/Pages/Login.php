<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public $name = '';

    public $phone = '';

    public $isLoading = false;

    public $errorMessage = '';

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'phone' => 'required|string|digits:10',
    ];

    protected function messages(): array
    {
        return [
            'name.required' => __('validation.name_required'),
            'name.min' => __('validation.name_min'),
            'phone.required' => __('validation.phone_required'),
            'phone.min' => __('validation.phone_min'),
        ];
    }

    public function login()
    {
        $this->isLoading = true;
        $this->errorMessage = '';

        $this->validate();
        try {

            // Check if user exists with this phone number
            $user = User::where('phone', $this->phone)->first();

            if (! $user) {
                // Create new user
                $user = User::create([
                    'name' => $this->name,
                    'phone' => $this->phone,
                    'email' => null, // We'll use phone as primary identifier
                    'role' => 'user',
                ]);
            } else {
                // Update existing user's information
                $user->update([
                    'name' => $this->name,
                ]);
            }

            // Login the user
            Auth::login($user);

            $this->isLoading = false;

            // Redirect to home page
            return redirect()->route('home')->with('success', __('alerts.welcome_swadeshi'));

        } catch (ValidationException $e) {
            $this->isLoading = false;
            $this->errorMessage = __('alerts.please_check_input');
        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->errorMessage = __('alerts.something_went_wrong');
        }
    }

    public function render()
    {
        return view('livewire.pages.login');
    }
}
