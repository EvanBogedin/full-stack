<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\CreateReviewRequest;
use App\Http\Requests\Api\GetReviewsRequest;
use App\Http\Requests\Api\UpdateReviewReactionRequest;
use App\Models\Review;
use App\Models\ReviewReaction;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function createReview(CreateReviewRequest $request): JsonResponse
    {
        try {
            Review::query()->create($request->validated());

            return response()->json(['message' => 'Review created successfully!'], 201);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getReviews(GetReviewsRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $productId = (int) ($validated['id'] ?? $validated['productId'] ?? $validated['product_id']);

        $reviews = Review::query()->where('product_id', $productId)->get();

        return response()->json($reviews);
    }

    public function updateReviewLikes(UpdateReviewReactionRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->updateReaction($validated['reviewID'], $validated['UserID'], 'like');

        return response()->json(['message' => 'Review likes updated successfully!']);
    }

    public function updateReviewDislikes(UpdateReviewReactionRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->updateReaction($validated['reviewID'], $validated['UserID'], 'dislike');

        return response()->json(['message' => 'Review dislikes updated successfully!']);
    }

    public function deleteReview(int $id): JsonResponse
    {
        Review::query()->whereKey($id)->delete();

        return response()->json(['message' => "Review with ID {$id} has been deleted"]);
    }

    private function updateReaction(int $reviewId, int $userId, string $reaction): void
    {
        ReviewReaction::query()->updateOrCreate(
            ['review_id' => $reviewId, 'user_id' => $userId],
            ['reaction' => $reaction],
        );

        $review = Review::query()->findOrFail($reviewId);

        $review->update([
            'likes_count' => ReviewReaction::query()
                ->where('review_id', $reviewId)
                ->where('reaction', 'like')
                ->count(),
            'dislikes_count' => ReviewReaction::query()
                ->where('review_id', $reviewId)
                ->where('reaction', 'dislike')
                ->count(),
        ]);
    }
}
