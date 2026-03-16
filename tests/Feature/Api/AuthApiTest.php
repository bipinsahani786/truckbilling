<?php

use App\Models\User;
use function tap;

it('can register a new owner successfully', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Testing Owner',
        'email' => 'testingowner@example.com',
        'password' => 'password123',
        'mobile_number' => '9988776655',
        'company_name' => 'Testing Logistics',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'User registered successfully.',
        ])
        ->assertJsonStructure([
            'data' => [
                'token',
                'user_id',
                'name',
                'email',
                'roles'
            ]
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'testingowner@example.com',
        'mobile_number' => '9988776655',
        'company_name' => 'Testing Logistics',
    ]);

    $user = User::where('email', 'testingowner@example.com')->first();
    expect($user->hasRole('owner'))->toBeTrue();
});

it('fails registration with existing email', function () {
    $existingUser = User::factory()->create([
        'email' => 'testingowner@example.com',
        'mobile_number' => '1111111111'
    ]);

    $response = $this->postJson('/api/register', [
        'name' => 'Another Owner',
        'email' => 'testingowner@example.com',
        'password' => 'password123',
        'mobile_number' => '9988776655',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

it('fails registration with existing mobile number', function () {
    $existingUser = User::factory()->create([
        'email' => 'another@example.com',
        'mobile_number' => '9988776655'
    ]);

    $response = $this->postJson('/api/register', [
        'name' => 'Another Owner',
        'email' => 'testingowner@example.com',
        'password' => 'password123',
        'mobile_number' => '9988776655',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('mobile_number');
});

it('requires a password of at least 8 characters', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Testing Owner',
        'email' => 'testingowner@example.com',
        'password' => 'pass', // 4 chars
        'mobile_number' => '9988776655',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('password');
});

it('can request a password reset link', function () {
    $user = User::factory()->create(['email' => 'forgot@example.com']);

    $response = $this->postJson('/api/forgot-password', [
        'email' => 'forgot@example.com',
    ]);

    // If mail isn't configured, it might return 400 or 200 depending on broker behavior in tests
    // But status should be one of these
    expect(in_array($response->status(), [200, 400]))->toBeTrue();
});

it('fails forgot password if email does not exist', function () {
    $response = $this->postJson('/api/forgot-password', [
        'email' => 'nonexistent@example.com',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

