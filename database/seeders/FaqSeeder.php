<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What services do you offer?',
                'answer' => 'We offer a wide range of services including web development, mobile app development, digital marketing, and cloud solutions.',
                'order' => 1,
            ],
            [
                'question' => 'How can I contact support?',
                'answer' => 'You can contact our support team via email at support@example.com or by calling our hotline at +1-234-567-890.',
                'order' => 2,
            ],
            [
                'question' => 'Do you provide custom solutions?',
                'answer' => 'Yes, we specialize in creating custom solutions tailored to meet the specific needs of your business.',
                'order' => 3,
            ],
            [
                'question' => 'What is your pricing model?',
                'answer' => 'Our pricing is project-based. We provide a detailed quote after understanding your requirements.',
                'order' => 4,
            ],
            [
                'question' => 'Where are you located?',
                'answer' => 'Our headquarters are located in New York City, but we serve clients globally.',
                'order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'order' => $faq['order'],
                    'active' => true,
                    'parent_id' => -1,
                ]
            );
        }
    }
}
