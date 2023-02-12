<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->productRepository->all();
            return response()->json($products, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productRepository->find($id);
            return response()->json($product, ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $product = $this->productRepository->createOrUpdate($data,0);
            return response()->json($product, ResponseAlias::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->all();
            $product = $this->productRepository->createOrUpdate($data, $id);
            return response()->json($product, ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productRepository->delete($id);
            return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchByNameAndCategory(Request $request): JsonResponse
    {
        try {
            $name = $request->input('name');
            $category = $request->input('category');

            $products = $this->productRepository->searchByNameAndCategory($name, $category);

            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchByCategory(Request $request, $category): JsonResponse
    {
        try{
            $products = $this->productRepository->searchByCategory($category);

             return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchByImage(Request $request): JsonResponse
    {
        try{
            $products = $this->productRepository->searchByImage($request->hasImage);

            return response()->json($products);
        } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findById(Request $request, $id): JsonResponse
    {
        try{
            $product = $this->productRepository->findById($id);

            return response()->json($product);
        } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
