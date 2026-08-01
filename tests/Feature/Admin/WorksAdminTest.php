<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorksAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
        $this->department = Department::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Builds the org website',
            'image' => 'departments/images/placeholder.jpg',
            'logo' => 'departments/logos/placeholder.jpg',
        ]);
    }

    public function test_index_lists_works(): void
    {
        Work::create([
            'name' => 'Portfolio Site',
            'description' => 'The org portfolio website',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('works.index'));

        $response->assertStatus(200)->assertSee('Portfolio Site');
    }

    public function test_index_paginates_works(): void
    {
        for ($i = 1; $i <= 11; $i++) {
            $work = Work::create([
                'name' => "Work {$i}",
                'description' => 'A work description',
                'image' => 'works/placeholder.jpg',
                'department_id' => $this->department->id,
            ]);
            $work->forceFill([
                'created_at' => now()->addSeconds($i),
                'updated_at' => now()->addSeconds($i),
            ])->save();
        }

        $response = $this->actingAs($this->admin)->get(route('works.index'));

        $response->assertStatus(200)
            ->assertSee('Work 1')
            ->assertSee('Work 10')
            ->assertDontSee('Work 11')
            ->assertSee('page=2', false);
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('works.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="department_id"', false)
            ->assertSee('name="image"', false);
    }

    public function test_store_creates_work(): void
    {
        $response = $this->actingAs($this->admin)->post(route('works.store'), [
            'name' => 'Mobile App',
            'description' => 'The org mobile app',
            'department_id' => $this->department->id,
            'image' => UploadedFile::fake()->image('work.jpg'),
        ]);

        $response->assertRedirect(route('works.index'));
        $this->assertDatabaseHas('works', ['name' => 'Mobile App']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $work = Work::create([
            'name' => 'Internal Tool',
            'description' => 'Internal dashboard',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('works.edit', $work));

        $response->assertStatus(200)->assertSee('value="Internal Tool"', false);
    }

    public function test_show_displays_work_details(): void
    {
        $work = Work::create([
            'name' => 'API Gateway',
            'description' => 'Central API gateway',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('works.show', $work));

        $response->assertStatus(200)->assertSee('API Gateway');
    }

    public function test_destroy_deletes_work(): void
    {
        $work = Work::create([
            'name' => 'Old Work',
            'description' => 'Deprecated work',
            'image' => 'works/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('works.destroy', $work));

        $response->assertRedirect(route('works.index'));
        $this->assertDatabaseMissing('works', ['id' => $work->id]);
    }
}
