<?php

namespace App\Filament\Resources\GameQuestions\Pages;

use App\Filament\Resources\GameQuestions\GameQuestionResource;
use App\Models\GameOption;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditGameQuestion extends EditRecord
{
    protected static string $resource = GameQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview_question')
                ->label('Preview Question')
                ->icon(Heroicon::OutlinedEye)
                ->modalHeading('Question Preview')
                ->modalContent(fn () => view('filament.forms.components.question-preview', [
                    'question' => $this->record->question,
                    'type' => $this->record->type,
                    'options' => $this->record->options->map(function ($option) {
                        return [
                            'option_text' => $option->option_text,
                            'option_type' => $option->optionable_type ? class_basename($option->optionable_type) : 'text',
                            'optionable_id' => $option->optionable_id,
                            'is_correct' => $option->is_correct,
                        ];
                    })->toArray(),
                ]))
                ->modalWidth('lg'),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Add options data to the form
        $data['options'] = $this->record->options->map(function ($option) {
            return [
                'option_text' => $option->option_text,
                'option_type' => $option->optionable_type ? class_basename($option->optionable_type) : 'text',
                'optionable_id' => $option->optionable_id,
                'optionable_type' => $option->optionable_type,
                'is_correct' => $option->is_correct,
                'sort_order' => $option->sort_order,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove options from the main data as they'll be handled separately
        $options = $data['options'] ?? [];
        unset($data['options']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Delete existing options
        $this->record->options()->delete();

        // Create new options
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
