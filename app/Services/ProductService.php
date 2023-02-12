<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use GuzzleHttp\Client;

class ProductService
{
    protected $productRepository;
    protected $client;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->client = new Client();
    }

    public function importProductsFromApiAndSave(): bool
    {
        try {
            $response = $this->client->get('https://fakestoreapi.com/products');
            $productsData = json_decode($response->getBody()->getContents(), true);
            foreach ($productsData as $productData) {
                $product = [
                    'name' => $productData['title'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'category' => $productData['category'],
                    'image_url' => $productData['image']
                ];
                $this->productRepository->createOrUpdate($product, $productData['id']);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function importSingleProductFromApiAndSave(int $id): bool
    {
        try {
            $response = $this->client->get('https://fakestoreapi.com/products/'.$id);
            $productsData = json_decode($response->getBody()->getContents(), true);

            foreach ($productsData as $productData) {
                $this->productRepository->createOrUpdate($productData, $productData['id']);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
