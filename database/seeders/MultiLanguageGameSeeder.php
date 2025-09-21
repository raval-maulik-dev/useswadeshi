<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use Illuminate\Database\Seeder;

class MultiLanguageGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a multi-language Swadeshi Quiz game
        $game = Game::create([
            'name' => 'Swadeshi Products Quiz',
            'name_hi' => 'स्वदेशी उत्पाद क्विज',
            'name_gu' => 'સ્વદેશી ઉત્પાદનો ક્વિઝ',
            'description' => 'Test your knowledge about Indian products and brands. Learn about local alternatives to foreign products.',
            'description_hi' => 'भारतीय उत्पादों और ब्रांड्स के बारे में अपने ज्ञान का परीक्षण करें। विदेशी उत्पादों के स्थानीय विकल्पों के बारे में जानें।',
            'description_gu' => 'ભારતીય ઉત્પાદનો અને બ્રાન્ડ્સ વિશે તમારા જ્ઞાનની પરીક્ષા કરો. વિદેશી ઉત્પાદનોના સ્થાનિક વિકલ્પો વિશે જાણો.',
            'locale' => 'en',
            'total_questions' => 5,
            'per_question_time' => 60,
            'allow_replay' => true,
            'show_correct_answers' => true,
            'is_active' => true,
            'max_attempts' => 3,
        ]);

        // Question 1: Which Indian brand is known for mobile phones?
        $question1 = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which Indian brand is known for mobile phones?',
            'question_hi' => 'कौन सा भारतीय ब्रांड मोबाइल फोन के लिए जाना जाता है?',
            'question_gu' => 'કયું ભારતીય બ્રાન્ડ મોબાઇલ ફોન માટે જાણીતું છે?',
            'type' => 'mcq',
            'difficulty' => 'easy',
            'points' => 10,
        ]);

        // Options for Question 1
        GameOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Micromax',
            'option_text_hi' => 'माइक्रोमैक्स',
            'option_text_gu' => 'માઇક્રોમેક્સ',
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        GameOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Samsung',
            'option_text_hi' => 'सैमसंग',
            'option_text_gu' => 'સેમસંગ',
            'is_correct' => false,
            'sort_order' => 2,
        ]);

        GameOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Apple',
            'option_text_hi' => 'एप्पल',
            'option_text_gu' => 'એપલ',
            'is_correct' => false,
            'sort_order' => 3,
        ]);

        GameOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Nokia',
            'option_text_hi' => 'नोकिया',
            'option_text_gu' => 'નોકિયા',
            'is_correct' => false,
            'sort_order' => 4,
        ]);

        // Question 2: Which Indian company manufactures Tata cars?
        $question2 = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which Indian company manufactures Tata cars?',
            'question_hi' => 'कौन सी भारतीय कंपनी टाटा कारों का निर्माण करती है?',
            'question_gu' => 'કયી ભારતીય કંપની ટાટા કારો બનાવે છે?',
            'type' => 'mcq',
            'difficulty' => 'easy',
            'points' => 10,
        ]);

        // Options for Question 2
        GameOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Tata Motors',
            'option_text_hi' => 'टाटा मोटर्स',
            'option_text_gu' => 'ટાટા મોટર્સ',
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        GameOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Mahindra',
            'option_text_hi' => 'महिंद्रा',
            'option_text_gu' => 'મહિન્દ્રા',
            'is_correct' => false,
            'sort_order' => 2,
        ]);

        GameOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Maruti Suzuki',
            'option_text_hi' => 'मारुति सुजुकी',
            'option_text_gu' => 'મારુતિ સુઝુકી',
            'is_correct' => false,
            'sort_order' => 3,
        ]);

        GameOption::create([
            'question_id' => $question2->id,
            'option_text' => 'Hyundai',
            'option_text_hi' => 'हुंडई',
            'option_text_gu' => 'હુન્ડાઈ',
            'is_correct' => false,
            'sort_order' => 4,
        ]);

        // Question 3: Which Indian brand is famous for tea?
        $question3 = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which Indian brand is famous for tea?',
            'question_hi' => 'कौन सा भारतीय ब्रांड चाय के लिए प्रसिद्ध है?',
            'question_gu' => 'કયું ભારતીય બ્રાન્ડ ચા માટે પ્રખ્યાત છે?',
            'type' => 'mcq',
            'difficulty' => 'medium',
            'points' => 15,
        ]);

        // Options for Question 3
        GameOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Tata Tea',
            'option_text_hi' => 'टाटा टी',
            'option_text_gu' => 'ટાટા ટી',
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        GameOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Lipton',
            'option_text_hi' => 'लिप्टन',
            'option_text_gu' => 'લિપ્ટન',
            'is_correct' => false,
            'sort_order' => 2,
        ]);

        GameOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Brooke Bond',
            'option_text_hi' => 'ब्रुक बॉन्ड',
            'option_text_gu' => 'બ્રુક બોન્ડ',
            'is_correct' => false,
            'sort_order' => 3,
        ]);

        GameOption::create([
            'question_id' => $question3->id,
            'option_text' => 'Red Label',
            'option_text_hi' => 'रेड लेबल',
            'option_text_gu' => 'રેડ લેબલ',
            'is_correct' => false,
            'sort_order' => 4,
        ]);

        // Question 4: Which Indian company owns Jio?
        $question4 = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which Indian company owns Jio?',
            'question_hi' => 'कौन सी भारतीय कंपनी जिओ की मालिक है?',
            'question_gu' => 'કયી ભારતીય કંપની જિયોની માલિક છે?',
            'type' => 'mcq',
            'difficulty' => 'medium',
            'points' => 15,
        ]);

        // Options for Question 4
        GameOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Reliance Industries',
            'option_text_hi' => 'रिलायंस इंडस्ट्रीज',
            'option_text_gu' => 'રિલાયન્સ ઇન્ડસ્ટ્રીઝ',
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        GameOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Bharti Airtel',
            'option_text_hi' => 'भारती एयरटेल',
            'option_text_gu' => 'ભારતી એરટેલ',
            'is_correct' => false,
            'sort_order' => 2,
        ]);

        GameOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Vodafone',
            'option_text_hi' => 'वोडाफोन',
            'option_text_gu' => 'વોડાફોન',
            'is_correct' => false,
            'sort_order' => 3,
        ]);

        GameOption::create([
            'question_id' => $question4->id,
            'option_text' => 'Idea',
            'option_text_hi' => 'आइडिया',
            'option_text_gu' => 'આઇડિયા',
            'is_correct' => false,
            'sort_order' => 4,
        ]);

        // Question 5: Which Indian brand is known for spices?
        $question5 = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which Indian brand is known for spices?',
            'question_hi' => 'कौन सा भारतीय ब्रांड मसालों के लिए जाना जाता है?',
            'question_gu' => 'કયું ભારતીય બ્રાન્ડ મસાલા માટે જાણીતું છે?',
            'type' => 'mcq',
            'difficulty' => 'hard',
            'points' => 20,
        ]);

        // Options for Question 5
        GameOption::create([
            'question_id' => $question5->id,
            'option_text' => 'MDH',
            'option_text_hi' => 'एमडीएच',
            'option_text_gu' => 'એમડીએચ',
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        GameOption::create([
            'question_id' => $question5->id,
            'option_text' => 'Everest',
            'option_text_hi' => 'एवरेस्ट',
            'option_text_gu' => 'એવરેસ્ટ',
            'is_correct' => false,
            'sort_order' => 2,
        ]);

        GameOption::create([
            'question_id' => $question5->id,
            'option_text' => 'Catch',
            'option_text_hi' => 'कैच',
            'option_text_gu' => 'કેચ',
            'is_correct' => false,
            'sort_order' => 3,
        ]);

        GameOption::create([
            'question_id' => $question5->id,
            'option_text' => 'Patanjali',
            'option_text_hi' => 'पतंजलि',
            'option_text_gu' => 'પતંજલિ',
            'is_correct' => false,
            'sort_order' => 4,
        ]);

        $this->command->info('Multi-language game content seeded successfully!');
        $this->command->info('Created game: '.$game->name);
        $this->command->info('Created '.$game->gameQuestions->count().' questions with Hindi and Gujarati translations');
    }
}
