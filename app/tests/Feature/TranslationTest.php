<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Translation;
use App\Models\Locale;
use App\Models\Tag;

class TranslationTest extends TestCase
{
    use RefreshDatabase;  // Ensures a fresh database for each test

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user and generate token
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('TestToken')->plainTextToken;
    }

    /** @test */
    public function it_can_store_a_translation()
    {
        $locale = Locale::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->postJson('/api/translations', [
            'locale_id' => $locale->id,
            'key' => 'greeting',
            'value' => 'Hello, world!',
            'tags' => ['web'],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('translations', ['key' => 'greeting']);
    }

    /** @test */
    public function it_can_fetch_a_translation()
    {
        $locale = Locale::factory()->create();
        $translation = Translation::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/translations/' . $translation->id);

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $translation->id,
                    'key' => $translation->key,
                ]);
    }

    /** @test */
    public function it_can_update_a_translation()
    {
        $locale = Locale::factory()->create();
        $translation = Translation::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/translations/' . $translation->id, [
            'value' => 'Updated value',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('translations', ['id' => $translation->id, 'value' => 'Updated value']);
    }

    /** @test */
    public function it_can_delete_a_translation()
    {
        $locale = Locale::factory()->create();
        $translation = Translation::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/translations/' . $translation->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('translations', ['id' => $translation->id]);
    }

    /** @test */
    public function it_can_search_translations_by_key()
    {
        $locale = Locale::factory()->create();
        Translation::factory()->create(['key' => 'hello-world']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/translations?key=hello');

        $response->assertStatus(200)
                ->assertJsonFragment(['key' => 'hello-world']);
    }

    /** @test */
    public function it_can_export_translations()
    {
        $locale = Locale::factory()->create();
        Translation::factory()->count(10)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token, // Include authentication token
            'Accept' => 'application/json',
        ])->getJson('/api/translations/export');

        $response->assertStatus(200);
        $response->assertJsonCount(10); // Ensure 10 translations are returned
    }
}
