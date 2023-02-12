<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class ImportProductsFromApi extends Command
{
    protected $signature = 'products:import {id?}';

    protected $description = 'Import products data from the API';

    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }


    public function handle()
    {
        $productId = $this->argument('id');

        if ($productId) {
            $result = $this->productService->importSingleProductFromApiAndSave($productId);

            if ($result) {
                $this->info("Product with ID $productId updated successfully.");
            } else {
                $this->error("Failed to update product with ID $productId.");
            }
        } else {
            $result = $this->productService->importProductsFromApiAndSave();

            if ($result) {
                $this->info('Products data updated successfully.');
            } else {
                $this->error('Failed to update products data.');
            }
        }
    }
}
