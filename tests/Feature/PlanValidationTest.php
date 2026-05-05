<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PlanValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'admin']);
    }

    public function test_description_must_not_exceed_255_characters()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->post(route('plans.store'), [
            'name' => 'Test Plan',
            'slug' => 'test-plan',
            'stripe_plan' => 'stripe_test',
            'price' => 100,
            'description' => str_repeat('a', 256),
            'duration' => 'mon',
        ]);

        $response->assertSessionHasErrors('description');
    }
}

