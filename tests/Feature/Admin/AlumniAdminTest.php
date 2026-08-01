<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlumniAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    public function test_index_lists_alumni(): void
    {
        Alumni::create([
            'name' => 'Alex Wong',
            'achievement' => 'National coding champion',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('alumni.index'));

        $response->assertStatus(200)->assertSee('Alex Wong');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('alumni.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="achievement"', false)
            ->assertSee('name="image"', false);
    }

    public function test_store_creates_alumni(): void
    {
        $response = $this->actingAs($this->admin)->post(route('alumni.store'), [
            'name' => 'Bella Putri',
            'achievement' => 'Best thesis award',
            'image' => UploadedFile::fake()->image('alumni.jpg'),
        ]);

        $response->assertRedirect(route('alumni.index'));
        $this->assertDatabaseHas('alumnis', ['name' => 'Bella Putri']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $alumni = Alumni::create([
            'name' => 'Carlos Diaz',
            'achievement' => 'Startup founder',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('alumni.edit', $alumni));

        $response->assertStatus(200)->assertSee('value="Carlos Diaz"', false);
    }

    public function test_show_displays_alumni_details(): void
    {
        $alumni = Alumni::create([
            'name' => 'Dina Marlina',
            'achievement' => 'Published researcher',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('alumni.show', $alumni));

        $response->assertStatus(200)->assertSee('Dina Marlina');
    }

    public function test_destroy_deletes_alumni(): void
    {
        $alumni = Alumni::create([
            'name' => 'Old Alumni',
            'achievement' => 'N/A',
            'image' => 'alumni/placeholder.jpg',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('alumni.destroy', $alumni));

        $response->assertRedirect(route('alumni.index'));
        $this->assertDatabaseMissing('alumnis', ['id' => $alumni->id]);
    }
}
