<?php

namespace App\Filament\Resources\GameQuestions\Pages;

use App\Filament\Resources\GameQuestions\GameQuestionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGameQuestion extends CreateRecord
{
    protected static string $resource = GameQuestionResource::class;
}
