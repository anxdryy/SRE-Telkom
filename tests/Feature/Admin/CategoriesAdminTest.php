<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Programs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_index_lists_categories(): void
    {
        Category::create(['name' => 'Activity']);

        $response = $this->actingAs($this->admin)->get(route('categories.index'));

        $response->assertStatus(200)->assertSee('Activity');
    }

    public function test_create_form_renders_required_field(): void
    {
        $response = $this->actingAs($this->admin)->get(route('categories.create'));

        $response->assertStatus(200)->assertSee('name="name"', false);
    }

    public function test_store_creates_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('categories.store'), [
            'name' => 'Research',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Research']);
    }

    public function test_edit_form_prefills_existing_value(): void
    {
        $category = Category::create(['name' => 'Competition']);

        $response = $this->actingAs($this->admin)->get(route('categories.edit', $category));

        $response->assertStatus(200)->assertSee('value="Competition"', false);
    }

    public function test_show_displays_category_details(): void
    {
        $category = Category::create(['name' => 'Workshop']);

        $response = $this->actingAs($this->admin)->get(route('categories.show', $category));

        $response->assertStatus(200)->assertSee('Workshop');
    }

    public function test_destroy_deletes_category(): void
    {
        $category = Category::create(['name' => 'Old Category']);

        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_destroy_blocks_deletion_when_category_has_programs(): void
    {
        $category = Category::create(['name' => 'Has Programs']);
        Programs::create([
            'title' => 'Attached Program',
            'slug' => 'attached-program',
            'desc' => 'A program blocking category deletion',
            'image' => 'programs/placeholder.jpg',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
