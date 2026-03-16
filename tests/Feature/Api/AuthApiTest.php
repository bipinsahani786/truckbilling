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
