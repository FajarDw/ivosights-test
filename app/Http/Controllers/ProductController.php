<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ProductRepositoryInterface;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductRequest $request): JsonResponse
    {
        $validated = $request->validated(); // Validate request
        $products = $this->productRepository->getAll(
            $validated['search'] ?? null,
            $validated['sort_by'] ?? 'created_at',
            $validated['sort_dir'] ?? 'asc',
            $validated['limit'] ?? 10
        );

        return BaseResponse::success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productRepository->create($request->validated());
        return BaseResponse::success($product, 'Product created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $product = $this->productRepository->getById($id);
        return BaseResponse::success($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id): JsonResponse
    {
        $product = $this->productRepository->update($id, $request->validated());
        return BaseResponse::success($product, 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $this->productRepository->delete($id);
        return BaseResponse::success(null, 'Product deleted');
    }
}
