<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class UserCrudTest extends TestCase
{
    
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        // Log in as the admin user
        $this->actingAs($this->admin);
    }

    public function test_user_creation()
    {
        $response = $this->post('/users', [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302); // Check for redirect
        $response->assertRedirect('/users'); // Assuming redirect to user list

        $this->assertDatabaseHas('users', [
            'email' => 'janedoe@example.com',
        ]);
    }

    public function test_user_creation_requires_username()
    {
        $response = $this->post('/users', [
            'email' => 'janedoe@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertDatabaseMissing('users', [
            'email' => 'janedoe@example.com',
        ]);
    }

    public function test_user_creation_requires_valid_email()
    {
        $response = $this->post('/users', [
            'username' => 'Jane Doe',
            'email' => 'invalid-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'username' => 'Jane Doe',
        ]);
    }

    public function test_user_creation_requires_password()
    {
        $response = $this->post('/users', [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', [
            'email' => 'janedoe@example.com',
        ]);
    }

    public function test_user_creation_requires_unique_email()
    {
        User::factory()->create([
            'email' => 'janedoe@example.com',
        ]);

        $response = $this->post('/users', [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_update()
    {
        $user = User::factory()->create([
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->put('/users/' . $user->id, [
            'username' => 'Jane Smith',
            'email' => 'janesmith@example.com',
        ]);

        $response->assertStatus(302); // Check for redirect
        $response->assertRedirect('/users'); // Assuming redirect to user list

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'Jane Smith',
            'email' => 'janesmith@example.com',
        ]);
    }

    public function test_user_update_requires_valid_email()
    {
        $user = User::factory()->create([
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->put('/users/' . $user->id, [
            'username' => 'Jane Smith',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email',
        ]);
    }

    public function test_user_update_requires_unique_email()
    {
        $user1 = User::factory()->create([
            'email' => 'janedoe@example.com',
        ]);

        $user2 = User::factory()->create([
            'email' => 'another@example.com',
        ]);

        $response = $this->put('/users/' . $user2->id, [
            'email' => 'janedoe@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_update_allows_partial_update()
    {
        $user = User::factory()->create([
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->put('/users/' . $user->id, [
            'username' => 'Jane Smith',
            'email' => 'janedoe@example.com',
        ]);

        $response->assertStatus(302); // Check for redirect
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'Jane Smith',
            'email' => 'janedoe@example.com',
        ]);
    }

    public function test_user_deletion()
    {
        $user = User::factory()->create([
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->delete('/users/' . $user->id);

        $response->assertStatus(302); // Check for redirect
        $response->assertRedirect('/users'); // Assuming redirect to user list

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_view()
    {
        $user = User::factory()->create([
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->get('/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertSee('Jane Doe'); // Check if the response contains the user's name
        $response->assertSee('janedoe@example.com'); // Check if the response contains the user's email
    }

}
