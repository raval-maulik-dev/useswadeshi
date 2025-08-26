<?php

namespace Database\Seeders;

use App\Models\GameOption;
use App\Models\GameQuestion;
use Illuminate\Database\Seeder;

class GameOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get questions that don't have options yet
        $questions = GameQuestion::whereDoesntHave('options')->get();

        foreach ($questions as $question) {
            $this->createOptionsForQuestion($question);
        }
    }

    /**
     * Create options for a specific question.
     */
    private function createOptionsForQuestion(GameQuestion $question): void
    {
        $optionCount = $this->getOptionCountForType($question->type);
        $correctCount = $this->getCorrectCountForType($question->type);

        // Create text-based options
        for ($i = 0; $i < $optionCount; $i++) {
            GameOption::create([
                'question_id' => $question->id,
                'option_text' => $this->generateOptionText($question, $i),
                'optionable_id' => null,
                'optionable_type' => null,
                'is_correct' => $i < $correctCount,
                'sort_order' => $i + 1,
            ]);
        }
    }

    /**
     * Get the number of options for a question type.
     */
    private function getOptionCountForType(string $type): int
    {
        return match ($type) {
            'true_false' => 2,
            'mcq' => 4,
            'multi_select' => 4,
            default => 4,
        };
    }

    /**
     * Get the number of correct answers for a question type.
     */
    private function getCorrectCountForType(string $type): int
    {
        return match ($type) {
            'true_false' => 1,
            'mcq' => 1,
            'multi_select' => rand(1, 2),
            default => 1,
        };
    }

    /**
     * Generate option text based on question type.
     */
    private function generateOptionText(GameQuestion $question, int $index): string
    {
        if ($question->type === 'true_false') {
            return $index === 0 ? 'True' : 'False';
        }

        // Commented out factory code to prevent generating fake data
        /*
        // Generate random option text for other types
        $options = [
            'Samsung', 'Apple', 'Tata', 'Reliance', 'Mahindra', 'Maruti',
            'Amul', 'Nike', 'Adidas', 'Coca-Cola', 'Pepsi', 'Honda',
            'Toyota', 'Hyundai', 'Ford', 'BMW', 'Mercedes', 'Audi',
            'Volkswagen', 'Skoda', 'Kia', 'MG', 'Jaguar', 'Land Rover',
        ];

        return fake()->randomElement($options);
        */
        
        // Return a default option text instead
        $options = [
            'Samsung', 'Apple', 'Tata', 'Reliance', 'Mahindra', 'Maruti',
            'Amul', 'Nike', 'Adidas', 'Coca-Cola', 'Pepsi', 'Honda',
            'Toyota', 'Hyundai', 'Ford', 'BMW', 'Mercedes', 'Audi',
            'Volkswagen', 'Skoda', 'Kia', 'MG', 'Jaguar', 'Land Rover',
        ];

        return $options[$index % count($options)];
    }
}
