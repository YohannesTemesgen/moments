<?php

namespace Tests\Feature;

use App\Models\Moment;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create tenants
        $tenant1 = Tenant::create(['id' => 'tenant1']);
        $tenant1->domains()->create(['domain' => 'tenant1.localhost']);

        $tenant2 = Tenant::create(['id' => 'tenant2']);
        $tenant2->domains()->create(['domain' => 'tenant2.localhost']);
    }

    public function test_tenant_data_is_isolated()
    {
        // Create users for each tenant
        $user1 = User::create([
            'tenant_id' => 'tenant1',
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'tenant_id' => 'tenant2',
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
        ]);

        // Initialize tenancy for tenant1
        tenancy()->initialize(Tenant::find('tenant1'));

        // Create data for tenant1
        Moment::create([
            'user_id' => $user1->id,
            'title' => 'Tenant 1 Moment',
            'description' => 'Description 1',
            'moment_date' => now()->toDateString(),
        ]);

        $this->assertEquals(1, Moment::count());
        $this->assertEquals('tenant1', Moment::first()->tenant_id);

        // Switch to tenant2
        tenancy()->end();
        tenancy()->initialize(Tenant::find('tenant2'));

        // Check if tenant1 data is visible
        $this->assertEquals(0, Moment::count());

        // Create data for tenant2
        Moment::create([
            'user_id' => $user2->id,
            'title' => 'Tenant 2 Moment',
            'description' => 'Description 2',
            'moment_date' => now()->toDateString(),
        ]);

        $this->assertEquals(1, Moment::count());
        $this->assertEquals('tenant2', Moment::first()->tenant_id);

        // Switch back to tenant1
        tenancy()->end();
        tenancy()->initialize(Tenant::find('tenant1'));

        // Check if tenant2 data is visible
        $this->assertEquals(1, Moment::count());
        $this->assertEquals('Tenant 1 Moment', Moment::first()->title);
    }

    public function test_user_authentication_is_tenant_aware()
    {
        // Create users
        User::create([
            'tenant_id' => 'tenant1',
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'tenant_id' => 'tenant2',
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
        ]);

        // Try to login as tenant1 user on tenant2 domain
        $response = $this->post('http://tenant2.localhost/login', [
            'email' => 'user1@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertFalse(auth()->check());

        // Login as tenant2 user on tenant2 domain
        $response = $this->post('http://tenant2.localhost/login', [
            'email' => 'user2@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('http://tenant2.localhost/admin/timeline');
        $this->assertTrue(auth()->check());
        $this->assertEquals('tenant2', auth()->user()->tenant_id);
    }
}
