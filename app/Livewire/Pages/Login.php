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
        'phone' => 'required|string|min:10|max:15',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'name.min' => 'Name must be at least 2 characters.',
        'phone.required' => 'Please enter your phone number.',
        'phone.min' => 'Phone number must be at least 10 digits.',
    ];

    public function login()
    {
        $this->isLoading = true;
        $this->errorMessage = '';

        try {
            $this->validate();

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
            return redirect()->route('home')->with('success', 'Welcome to Swadeshi Abhiyan!');

        } catch (ValidationException $e) {
            $this->isLoading = false;
            $this->errorMessage = 'Please check your input and try again.';
        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->errorMessage = 'Something went wrong. Please try again.';
        }
    }

    public function render()
    {
        return view('livewire.pages.login')
            ->layout('components.layouts.app');
    }
}
