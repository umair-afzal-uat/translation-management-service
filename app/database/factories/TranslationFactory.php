<?php

namespace Database\Factories;

use App\Models\Translation;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        return [
            'locale_id' => Locale::inRandomOrder()->first()->id,
            'key' => Str::uuid(),  // Ensures uniqueness without extra DB queries
            'value' => $this->faker->sentence,
        ];
    }
}