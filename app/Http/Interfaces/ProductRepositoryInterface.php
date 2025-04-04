<?php

namespace App\Http\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getAll($search, $sortBy, $sortDir, $limit);
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
