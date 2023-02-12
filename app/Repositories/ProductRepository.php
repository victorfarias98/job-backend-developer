<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository
{
    public function all()
    {
        try {
            return Product::all();
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve products: " . $e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function find(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                throw new ModelNotFoundException;
            }

            return $product;
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve product with ID {$id}: " . $e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function createOrUpdate(array $data, int $id = 0)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return Product::create($data);
            }

            $product->update($data);
            return $product;
        } catch (\Exception $e) {
            throw new \Exception("Failed to create or update product with ID {$id}: " . $e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function update(int $id, array $data)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                throw new ModelNotFoundException;
            }

            $product->update($data);
            return $product;
        } catch (\Exception $e) {
            throw new \Exception("Failed to update product with ID {$id}: " . $e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                throw new ModelNotFoundException;
            }

            $product->delete();

            return true;
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete product with ID {$id}: " . $e->getMessage());
        }
    }
    public function searchByNameAndCategory($name, $category)
    {
        try{
            return Product::where('name', 'like', "%{$name}%")
                ->where('category', 'like', "%{$category}%")
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchByCategory($category)
    {
        try {
            return Product::where('category', 'like', "%{$category}%")->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchByImage(bool $hasImage)
    {
        try {
            if ($hasImage) {
                return Product::whereNotNull('image_url')
                    ->get();
            } else {
                return Product::whereNull('image_url')
                    ->get();
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

}
