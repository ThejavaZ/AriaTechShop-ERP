<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class RoleAccessTest extends TestCase
{
    public function test_user_without_permission_cannot_delete_sales()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete('/api/sales/1');

        $response->assertStatus(403);
    }
}