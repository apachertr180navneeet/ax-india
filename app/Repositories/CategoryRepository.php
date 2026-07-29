<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function __construct(private Category $model) {}

    public function getAll(): Collection
    {
        return $this->model->with('children')->orderBy('sort_order')->get();
    }

    public function getActive(): Collection
    {
        return $this->model->where('is_active', true)
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }

    public function getWithVideoCount(): Collection
    {
        return $this->model->withCount('videos')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function findById(int $id): ?Category
    {
        return $this->model->find($id);
    }

    public function create(array $data): Category
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->findById($id);
        if (!$category) {
            return false;
        }
        return $category->update($data);
    }

    public function delete(int $id): bool
    {
        $category = $this->findById($id);
        if (!$category) {
            return false;
        }
        return $category->delete();
    }
}
