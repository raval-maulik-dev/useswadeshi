<?php

namespace App\Filament\Resources\GameQuestions\Pages;

use App\Filament\Resources\GameQuestions\GameQuestionResource;
use App\Models\GameOption;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateGameQuestion extends CreateRecord
{
    protected static string $resource = GameQuestionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validate options data
        $this->validateOptions($data);

        // Remove options from the main data as they'll be handled separately
        unset($data['options']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Create the options for the question
        $options = $this->form->getState()['options'] ?? [];

        foreach ($options as $index => $optionData) {
            // Only create options that have content
            if (! empty($optionData['option_text']) || ! empty($optionData['optionable_id'])) {
                GameOption::create([
                    'question_id' => $this->record->id,
                    'option_text' => $optionData['option_text'] ?? null,
                    'optionable_id' => $optionData['optionable_id'] ?? null,
                    'optionable_type' => $optionData['option_type'] ?? null,
                    'is_correct' => $optionData['is_correct'] ?? false,
                    'sort_order' => $optionData['sort_order'] ?? ($index + 1),
                ]);
            }
        }
    }

    protected function validateOptions(array $data): void
    {
        $options = $data['options'] ?? [];

        // Filter out empty options
        $validOptions = collect($options)->filter(function ($option) {
            return ! empty($option['option_text']) || ! empty($option['optionable_id']);
        })->toArray();

        // Validate minimum and maximum options
        if (count($validOptions) < 2) {
            throw ValidationException::withMessages([
                'options' => 'At least 2 options are required.',
            ]);
        }

        if (count($validOptions) > 6) {
            throw ValidationException::withMessages([
                'options' => 'Maximum 6 options allowed.',
            ]);
        }

        // Validate that at least one option is marked as correct
        $hasCorrectOption = collect($validOptions)->contains('is_correct', true);

        if (! $hasCorrectOption) {
            throw ValidationException::withMessages([
                'options' => 'At least one option must be marked as correct.',
            ]);
        }

        // For single answer questions, ensure only one option is correct
        if ($data['type'] === 'mcq' || $data['type'] === 'true_false') {
            $correctOptionsCount = collect($validOptions)->where('is_correct', true)->count();
            if ($correctOptionsCount > 1) {
                throw ValidationException::withMessages([
                    'options' => 'Single answer questions can only have one correct option.',
                ]);
            }
        }

        // Validate individual options
        foreach ($validOptions as $index => $option) {
            if (empty($option['option_type'])) {
                throw ValidationException::withMessages([
                    'options' => 'Option '.($index + 1).' must have a type selected.',
                ]);
            }

            if (! in_array($option['option_type'], ['text', 'product', 'brand'])) {
                throw ValidationException::withMessages([
                    'options' => 'Option '.($index + 1).' has an invalid type.',
                ]);
            }

            // Validate required fields based on option type
            if ($option['option_type'] === 'text' && empty($option['option_text'])) {
                throw ValidationException::withMessages([
                    'options' => 'Option '.($index + 1).' text is required for text options.',
                ]);
            }

            if (in_array($option['option_type'], ['product', 'brand']) && empty($option['optionable_id'])) {
                throw ValidationException::withMessages([
                    'options' => 'Option '.($index + 1).' must select an item for this option type.',
                ]);
            }

            // Validate sort_order if provided
            if (! empty($option['sort_order']) && (! is_numeric($option['sort_order']) || $option['sort_order'] < 1)) {
                throw ValidationException::withMessages([
                    'options' => 'Option '.($index + 1).' sort order must be a positive number.',
                ]);
            }
        }
    }
}
