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
                    "{$name} A-Z" => "{$sortable}|asc",
                    "{$name} Z-A" => "{$sortable}|desc",
                ];
            })
            ->mapWithKeys(function ($sortable) {
                return $sortable;
            })
            ->all();
    }

    public function scopeWithSortables($query)
    {
        if (!in_array(request()->get('sort_by'), $this->getSortables())) {
            return $query;
        }

        list($sort, $order) = Str::of(request()->get('sort_by'))->explode('|');

        return $query->orderBy($sort, $order);
    }
}
