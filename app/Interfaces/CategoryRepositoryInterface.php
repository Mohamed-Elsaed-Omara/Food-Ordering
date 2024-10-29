<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function storeCategory($request);
    public function getById(int $id);
    public function updateCategory($request, Category $category);
    public function destroy(Category $category);
}
