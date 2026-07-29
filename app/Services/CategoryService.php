<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    use Sluggable;

    public function __construct(private Category $category, private CategoryRepository $categoryRepository) {}

    public function getAll(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getActive(): Collection
    {
        return $this->categoryRepository->getActive();
    }

    public function getWithVideoCount(): Collection
    {
        return $this->categoryRepository->getWithVideoCount();
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function create(array $data): Category
    {
        try {
            $data['slug'] = $data['slug'] ?? $this->generateSlug($this->category, $data['name']);
            $category = $this->categoryRepository->create($data);

            Log::info('Category created', ['category_id' => $category->id]);

            return $category;
        } catch (\Exception $e) {
            Log::error('Category creation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $result = $this->categoryRepository->update($id, $data);

            Log::info('Category updated', ['category_id' => $id]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Category update failed', ['category_id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $result = $this->categoryRepository->delete($id);

            Log::info('Category deleted', ['category_id' => $id]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Category deletion failed', ['category_id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}
