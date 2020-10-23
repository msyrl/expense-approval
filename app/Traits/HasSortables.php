<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSortables
{
    public function getSortables(): array
    {
        return collect($this->sortables)
            ->map(function ($sortable) {
                $name = collect(Str::of($sortable)->explode('_'))
                    ->map(function ($name) {
                        return Str::ucfirst($name);
                    })
                    ->join(' ');

                return [
                    (object) [
                        'name' => "{$name} A-Z",
                        'value' => "{$sortable}|asc",
                    ],
                    (object) [
                        'name' => "{$name} Z-A",
                        'value' => "{$sortable}|desc",
                    ],
                ];
            })
            ->flatten(1)
            ->all();
    }

    public function scopeWithSortables($query)
    {
        if (
            !request()->filled('sort_by')
            || !$this->canSort(request()->get('sort_by'))
        ) {
            return $query->orderBy('id', 'desc');
        }

        list($sort, $order) = Str::of(request()->get('sort_by'))->explode('|');

        return $query->orderBy($sort, $order);
    }

    public function scopeGetPaginate($query)
    {
        return $query->withSortables()->paginate(request()->get('per_page', 15));
    }

    private function canSort(string $value)
    {
        return in_array($value, array_column($this->getSortables(), 'value'));
    }
}
