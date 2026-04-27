<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\CreateProductRequest;
use App\Http\Requests\Api\GetProductByIdRequest;
use App\Http\Requests\Api\SearchProductsRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function createProduct(CreateProductRequest $request): JsonResponse
    {
        Product::query()->create($request->validated());

        return response()->json(['message' => 'Product created successfully!'], 201);
    }

    public function getProductById(GetProductByIdRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $productId = (int) ($validated['id'] ?? $validated['productId'] ?? $validated['product_id']);

        $product = Product::query()->find($productId);

        return response()->json($product);
    }

    public function getAllProducts(): JsonResponse
    {
        return response()->json(Product::query()->get());
    }

    public function search(SearchProductsRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $query = Product::query();

        if (! empty($validated['query'])) {
            $search = $validated['query'];
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        if (! empty($validated['tags'])) {
            foreach ($validated['tags'] as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        $offset = $validated['offset'] ?? 0;
        $limit = $validated['numOfResults'] ?? 20;

        return response()->json($query->offset($offset)->limit($limit)->get());
    }

    public function updateProduct(UpdateProductRequest $request): JsonResponse
    {
        $validated = $request->validated();

        Product::query()->whereKey($validated['productId'])->update($validated['updateProduct']);

        return response()->json(['message' => 'Product updated successfully!']);
    }

    public function deleteProduct(int $id): JsonResponse
    {
        Product::query()->whereKey($id)->delete();

        return response()->json(['message' => "Product with ID {$id} has been deleted"]);
    }
}
