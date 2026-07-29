<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    public function scopeSearch(Builder $query, string $term, array $fields): Builder
    {
        return $query->where(function (Builder $q) use ($term, $fields): Builder {
            foreach ($fields as $field) {
                $q->orWhere($field, 'like', "%{$term}%");
            }

            return $q;
        });
    }
}
