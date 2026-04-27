<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Services\AiService;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        try {
            $reviewObject = $request->all();

            // Call AI service
            $honestyScore = app(AiService::class)->analyze($reviewObject['review']);

            $reviewObject['honesty_score'] = $honestyScore;

            Review::create($reviewObject);

            return response()->json(['message' => 'Review created successfully!'], 201);
        } catch (\Exception $e) {
            \Log::error("Error creating review: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}

