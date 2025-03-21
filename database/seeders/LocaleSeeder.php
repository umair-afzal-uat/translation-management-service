<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 10 locales using the factory
        \App\Models\Locale::factory()->count(10)->create();

        $this->command->info('Locales seeded successfully!');
    } 
}
