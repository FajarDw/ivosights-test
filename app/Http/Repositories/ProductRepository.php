<?php

use App\Models\Product;

class ProductRepository
{
    public function create(array $data)
    {
        // Create and persist the blog post in the database
        return Product::create($data);
    }
}
