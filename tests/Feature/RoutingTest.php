<?php

namespace Tests\Feature;

use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_guest_to_login(): void
    {
        $this->get('/')
            ->assertRedirect(route('login'));
    }

    public function test_root_redirects_member_to_stocks(): void
    {
        $member = User::factory()->member()->create();

        $this->actingAs($member)
            ->get('/')
            ->assertRedirect(route('stocks.index'));
    }

    public function test_root_redirects_admin_to_admin_users(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/')
            ->assertRedirect(route('admin.users'));
    }

    public function test_member_and_admin_route_protection(): void
    {
        $member = User::factory()->member()->create();
        $otherMember = User::factory()->member()->create();
        $admin = User::factory()->admin()->create();
        $stock = Stock::factory()->create(['user_id' => $member->id]);

        // Member can access own stocks & detail
        $this->actingAs($member)->get('/stocks')->assertStatus(200);
        $this->actingAs($member)->get("/stocks/{$stock->id}")->assertStatus(200);

        // Other member cannot access someone else's stock detail
        $this->actingAs($otherMember)->get("/stocks/{$stock->id}")->assertStatus(403);

        // Admin cannot access member /stocks route (role:member)
        $this->actingAs($admin)->get('/stocks')->assertStatus(403);

        // Admin can access /admin/users and /admin/users/{user}/stocks
        $this->actingAs($admin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($admin)->get("/admin/users/{$member->id}/stocks")->assertStatus(200);
    }

    public function test_health_check_endpoint(): void
    {
        $this->get('/up')
            ->assertStatus(200);
    }
}
