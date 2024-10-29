<?php
namespace App\Repositories;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface{

    public function storeCategory($request): void
    {
        $dataInput = $request->validated();

        $dataInput['slug'] = Str::slug($request->name);

        Category::create($dataInput);
    }

    public function getById($id): Category
    {
        return Category::findOrFail($id);
    }

    public function updateCategory($request,Category $category): void
    {
        $dataInput = $request->validated();
        $category->update($dataInput);
    }

    public function destroy(Category $category): void
    {
        $category->delete();
    }
}
