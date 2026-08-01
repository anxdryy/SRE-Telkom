<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Programs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProgramsAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
        $this->category = Category::create(['name' => 'Activity']);
    }

    public function test_index_lists_programs(): void
    {
        Programs::create([
            'title' => 'Coding Bootcamp',
            'slug' => 'coding-bootcamp',
            'desc' => 'A hands-on bootcamp',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('programs.index'));

        $response->assertStatus(200)->assertSee('Coding Bootcamp');
    }

    public function test_index_paginates_programs(): void
    {
        for ($i = 1; $i <= 11; $i++) {
            $program = Programs::create([
                'title' => "Program {$i}",
                'slug' => "program-{$i}",
                'desc' => 'A program description',
                'image' => 'programs/placeholder.jpg',
                'category_id' => $this->category->id,
            ]);
            $program->forceFill([
                'created_at' => now()->addSeconds($i),
                'updated_at' => now()->addSeconds($i),
            ])->save();
        }

        $response = $this->actingAs($this->admin)->get(route('programs.index'));

        $response->assertStatus(200)
            ->assertSee('Program 1')
            ->assertSee('Program 10')
            ->assertDontSee('Program 11')
            ->assertSee('page=2', false);
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('programs.create'));

        $response->assertStatus(200)
            ->assertSee('name="title"', false)
            ->assertSee('name="desc"', false)
            ->assertSee('name="category_id"', false)
            ->assertSee('name="image"', false)
            ->assertSee('name="instagram"', false);
    }

    public function test_store_creates_program(): void
    {
        $response = $this->actingAs($this->admin)->post(route('programs.store'), [
            'title' => 'Hackathon 2026',
            'desc' => 'Annual hackathon',
            'category_id' => $this->category->id,
            'image' => UploadedFile::fake()->image('program.jpg'),
            'instagram' => 'https://instagram.com/sre',
        ]);

        $response->assertRedirect(route('programs.index'));
        $this->assertDatabaseHas('programs', ['title' => 'Hackathon 2026']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $program = Programs::create([
            'title' => 'Research Sprint',
            'slug' => 'research-sprint',
            'desc' => 'A research sprint',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('programs.edit', $program));

        $response->assertStatus(200)->assertSee('value="Research Sprint"', false);
    }

    public function test_show_displays_program_details(): void
    {
        $program = Programs::create([
            'title' => 'Demo Day',
            'slug' => 'demo-day',
            'desc' => 'Showcasing student projects',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('programs.show', $program));

        $response->assertStatus(200)->assertSee('Demo Day');
    }

    public function test_destroy_deletes_program(): void
    {
        $program = Programs::create([
            'title' => 'Old Program',
            'slug' => 'old-program',
            'desc' => 'Deprecated',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('programs.destroy', $program));

        $response->assertRedirect(route('programs.index'));
        $this->assertDatabaseMissing('programs', ['id' => $program->id]);
    }
}
