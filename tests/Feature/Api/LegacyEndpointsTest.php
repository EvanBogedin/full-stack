<?php

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('logs in with name and password and returns a token', function (): void {
    User::query()->create([
        'name' => 'alex',
        'email' => 'alex@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'name' => 'alex',
        'password' => 'password123',
    ])->assertOk()
        ->assertJsonStructure(['token', 'message']);

    expect($response->json('token'))->toContain('|');
});

it('searches products using query and tags', function (): void {
    Product::query()->create([
        'name' => 'Phone Case',
        'description' => 'Durable case',
        'price' => 19.99,
        'tags' => ['tech', 'accessories'],
    ]);

    Product::query()->create([
        'name' => 'Coffee Beans',
        'description' => 'Dark roast',
        'price' => 12.50,
        'tags' => ['food'],
    ]);

    $this->postJson('/api/search', [
        'query' => 'Phone',
        'tags' => ['tech'],
        'offset' => 0,
        'numOfResults' => 10,
    ])->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment(['name' => 'Phone Case']);
});

it('updates review likes and dislikes', function (): void {
    $user = User::factory()->create();
    $product = Product::query()->create([
        'name' => 'Keyboard',
        'description' => 'Mechanical keyboard',
        'price' => 99.00,
        'tags' => ['tech'],
    ]);

    $review = Review::query()->create([
        'review' => 'Great quality.',
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);

    $this->putJson('/api/updateReviewLikes', [
        'reviewID' => $review->id,
        'UserID' => $user->id,
    ])->assertOk();

    $this->putJson('/api/updateReviewDislikes', [
        'reviewID' => $review->id,
        'UserID' => $user->id,
    ])->assertOk();

    $review->refresh();

    expect($review->likes_count)->toBe(0)
        ->and($review->dislikes_count)->toBe(1);
});
