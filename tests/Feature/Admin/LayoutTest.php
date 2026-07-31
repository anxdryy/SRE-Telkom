<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_render_sidebar_with_all_resource_links(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('departments.index'));

        $response->assertStatus(200);
        $response->assertSee(route('departments.index'), false);
        $response->assertSee(route('members.index'), false);
        $response->assertSee(route('categories.index'), false);
        $response->assertSee(route('programs.index'), false);
        $response->assertSee(route('works.index'), false);
        $response->assertSee(route('alumni.index'), false);
    }

    public function test_success_flash_message_is_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['success' => 'Test flash message'])
            ->get(route('departments.index'));

        $response->assertSee('Test flash message');
    }
}
