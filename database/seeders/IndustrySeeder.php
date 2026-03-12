<?php

namespace Database\Seeders;

use App\Models\McqQuestion;
use App\Models\McqOption;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            'Restaurants & Cafes' => [
                'positive' => [
                    ['What did you enjoy most?', ['Food Quality','Service Speed','Ambience','Staff Friendliness']],
                    ['How was the waiting time?', ['Very Quick','Acceptable','A little long']],
                ],
                'negative' => [
                    ['What could we improve?', ['Food Quality','Service Speed','Cleanliness','Staff Behaviour']],
                ],
            ],
            // More industries could be added here
        ];

        foreach ($industries as $industry => $flows) {
            foreach ($flows as $flowType => $questions) {
                foreach ($questions as $qData) {
                    $question = McqQuestion::create([
                        'industry_category' => $industry,
                        'question_text' => $qData[0],
                        'flow_type' => $flowType,
                    ]);

                    foreach ($qData[1] as $index => $optionText) {
                        McqOption::create([
                            'mcq_question_id' => $question->id,
                            'option_text' => $optionText,
                            'order' => $index,
                        ]);
                    }
                }
            }
        }
    }
}
