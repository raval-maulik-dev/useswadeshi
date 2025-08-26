<?php

namespace App\Filament\Resources\GameQuestions\Pages;

use App\Filament\Resources\GameQuestions\GameQuestionResource;
use App\Models\GameOption;
use Filament\Resources\Pages\CreateRecord;

class CreateGameQuestion extends CreateRecord
{
    protected static string $resource = GameQuestionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove options from the main data as they'll be handled separately
        $options = $data['options'] ?? [];
        unset($data['options']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Create the options for the question
        $options = $this->form->getState()['options'] ?? [];

        foreach ($options as $index => $optionData) {
            if (! empty($optionData['option_text']) || ! empty($optionData['optionable_id'])) {
                GameOption::create([
                    'question_id' => $this->record->id,
                    'option_text' => $optionData['option_text'] ?? null,
                    'optionable_id' => $optionData['optionable_id'] ?? null,
                    'optionable_type' => $optionData['optionable_type'] ?? null,
                    'is_correct' => $optionData['is_correct'] ?? false,
                    'sort_order' => $optionData['sort_order'] ?? ($index + 1),
                ]);
            }
        }
    }
}
