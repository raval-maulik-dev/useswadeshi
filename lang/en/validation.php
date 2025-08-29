<?php

return [
    // Name Validation
    'name_required' => 'Please enter your name.',
    'name_min' => 'Name must be at least 2 characters.',
    'name_max' => 'Name cannot exceed 255 characters.',

    // Phone Validation
    'phone_required' => 'Please enter your phone number.',
    'phone_min' => 'Phone number must be at least 10 digits.',
    'phone_max' => 'Phone number cannot exceed 15 digits.',
    'phone_unique' => 'This phone number is already registered.',

    // Email Validation
    'email_required' => 'Please enter your email address.',
    'email_email' => 'Please enter a valid email address.',
    'email_unique' => 'This email is already registered.',

    // Password Validation
    'password_required' => 'Please enter your password.',
    'password_min' => 'Password must be at least 8 characters.',
    'password_confirmed' => 'Password confirmation does not match.',

    // General Validation
    'required_field' => 'This field is required.',
    'invalid_format' => 'Invalid format.',
    'min_length' => 'This field must be at least :min characters.',
    'max_length' => 'This field cannot exceed :max characters.',

    // Quiz Validation
    'quiz_not_found' => 'Quiz not found.',
    'question_not_found' => 'Question not found.',
    'invalid_answer' => 'Invalid answer.',
    'time_expired' => 'Time has expired.',
    'already_completed' => 'You have already completed this quiz.',
    'cannot_replay' => 'Cannot replay this game!',
    'game_not_found' => 'Game not found!',

    // Pledge Validation
    'pledge_text_required' => 'Please enter your pledge text.',
    'pledge_text_min' => 'Pledge text must be at least 10 characters.',
    'pledge_text_max' => 'Pledge text cannot exceed 500 characters.',
    'selected_products_required' => 'Please select at least one product.',

    // Profile Validation
    'city_max' => 'City name cannot exceed 255 characters.',
    'state_max' => 'State name cannot exceed 255 characters.',
    'country_max' => 'Country name cannot exceed 255 characters.',
];
