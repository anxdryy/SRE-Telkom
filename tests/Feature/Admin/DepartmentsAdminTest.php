<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DepartmentsAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    private function makeDepartment(array $overrides = []): Department
    {
        return Department::create(array_merge([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Builds the org website',
            'image' => 'departments/images/placeholder.jpg',
            'logo' => 'departments/logos/placeholder.jpg',
        ], $overrides));
    }

    public function test_index_lists_departments(): void
    {
        $this->makeDepartment();

        $response = $this->actingAs($this->admin)->get(route('departments.index'));

        $response->assertStatus(200)->assertSee('Web Development');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('departments.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="image"', false)
            ->assertSee('name="logo"', false);
    }

    public function test_store_creates_department(): void
    {
        $response = $this->actingAs($this->admin)->post(route('departments.store'), [
            'name' => 'Data Science',
            'description' => 'Data-focused department',
            'image' => UploadedFile::fake()->image('bg.jpg'),
            'logo' => UploadedFile::fake()->image('logo.jpg'),
        ]);

        $response->assertRedirect(route('departments.index'));
        $this->assertDatabaseHas('departments', ['name' => 'Data Science']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $department = $this->makeDepartment(['name' => 'Cyber Security', 'slug' => 'cyber-security']);

        $response = $this->actingAs($this->admin)->get(route('departments.edit', $department));

        $response->assertStatus(200)->assertSee('value="Cyber Security"', false);
    }

    public function test_show_displays_department_details(): void
    {
        $department = $this->makeDepartment(['name' => 'Networking', 'slug' => 'networking']);

        $response = $this->actingAs($this->admin)->get(route('departments.show', $department));

        $response->assertStatus(200)->assertSee('Networking');
    }

    public function test_destroy_deletes_department_without_members(): void
    {
        $department = $this->makeDepartment(['name' => 'Old Dept', 'slug' => 'old-dept']);

        $response = $this->actingAs($this->admin)->delete(route('departments.destroy', $department));

        $response->assertRedirect(route('departments.index'));
        $this->assertDatabaseMissing('departments', ['id' => $department->id]);
    }
}
