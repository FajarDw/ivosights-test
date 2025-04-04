<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\RecordsNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll($search, $sortBy, $sortDir, $limit)
    {
        $query = Product::query();

        // find by product name
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Sorting by specific column
        $allowedSortFields = ['name', 'price', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'created_at';
        $sortDir = $sortDir === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortBy, $sortDir);
        return $query->paginate($limit);
    }

    public function getById($id)
    {
        $product = Product::where('uid', $id)->first();
        if (!$product) {
            throw new RecordsNotFoundException("Produk tidak ditemukan.");
        }
        return $product;
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->getById($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->getById($id);
        return $product->delete();
    }
}
