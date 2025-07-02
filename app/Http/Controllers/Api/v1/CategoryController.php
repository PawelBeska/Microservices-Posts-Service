<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Categories\SaveCategoryAction;
use App\Data\Categories\SaveCategoryData;
use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CategoryResource;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->getAll();

        return $this->successResponse(
            CategoryResource::collection($categories)
        );
    }


    public function store(SaveCategoryData $data): JsonResponse
    {
        $category = SaveCategoryAction::run(
            $data
        );

        return $this->successResponse(
            CategoryResource::make($category)
        );
    }

    public function show(Category $category): JsonResponse
    {
        return $this->successResponse(
            CategoryResource::make($category)
        );
    }


    public function update(SaveCategoryData $data, Category $category): JsonResponse
    {
        $category = SaveCategoryAction::run(
            $data,
            $category
        );

        return $this->successResponse(
            CategoryResource::make($category)
        );
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->codeResponse();
    }
}
