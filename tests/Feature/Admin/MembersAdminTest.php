<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MembersAdminTest extends TestCase
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

    public function test_index_lists_members(): void
    {
        Member::create([
            'name' => 'Jane Doe',
            'role' => 'Frontend Engineer',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('members.index'));

        $response->assertStatus(200)->assertSee('Jane Doe');
    }

    public function test_create_form_renders_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('members.create'));

        $response->assertStatus(200)
            ->assertSee('name="name"', false)
            ->assertSee('name="role"', false)
            ->assertSee('name="department_id"', false)
            ->assertSee('name="image"', false)
            ->assertSee($this->department->name);
    }

    public function test_store_creates_member(): void
    {
        $response = $this->actingAs($this->admin)->post(route('members.store'), [
            'name' => 'John Smith',
            'role' => 'Backend Engineer',
            'department_id' => $this->department->id,
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', ['name' => 'John Smith']);
    }

    public function test_edit_form_prefills_existing_values(): void
    {
        $member = Member::create([
            'name' => 'Amy Lee',
            'role' => 'Designer',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('members.edit', $member));

        $response->assertStatus(200)->assertSee('value="Amy Lee"', false);
    }

    public function test_show_displays_member_details(): void
    {
        $member = Member::create([
            'name' => 'Chris Tan',
            'role' => 'QA Engineer',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('members.show', $member));

        $response->assertStatus(200)->assertSee('Chris Tan');
    }

    public function test_destroy_deletes_member(): void
    {
        $member = Member::create([
            'name' => 'Old Member',
            'role' => 'Alumnus Role',
            'image' => 'members/placeholder.jpg',
            'department_id' => $this->department->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('members.destroy', $member));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }
}
